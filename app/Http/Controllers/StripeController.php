<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Stripe\Stripe;
use App\Models\Plan;
use App\Models\Pedido;
use App\Models\Usuario;
use App\Models\Articulo;
use App\Models\Producto;
use App\Models\Suscripcion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Stripe\Subscription as StripeSubscription;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        $usuario = Auth::user();

        // Ajusta estas validaciones a tu caso real
        $validated = $request->validate([
            'stripe_price_id' => 'nullable|string',
            'producto_id'     => 'nullable|integer',
            'quantity'        => 'nullable|integer|min:1',
        ]);

        if (! $usuario) {
            abort(401, 'No autenticado');
        }

        // 1) Resolver el price_id de Stripe
        // $stripePriceId = $validated['stripe_price_id'] ?? null;
        $stripePriceId = 'price_1SUqw4Dby92PFs9nlY1RdgRI';

        if (! $stripePriceId && ! empty($validated['producto_id'])) {
            // EJEMPLO: producto con campo stripe_price_id
            $producto = Articulo::findOrFail($validated['producto_id']);
            $stripePriceId = $producto->stripe_price_id;
        }

        if (! $stripePriceId) {
            abort(422, 'Falta stripe_price_id o producto_id');
        }

        $quantity = $validated['quantity'] ?? 1;

        // 2) Generar sesión de Stripe Checkout con Cashier
        $checkout = $usuario->checkout(
            [$stripePriceId => $quantity],
            [
                // Cambia estas rutas por las tuyas
                'success_url' => route('panel_inicio') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => route('panel_inicio'),
                // Aquí puedes mandar metadata para enlazar con tu pedido interno
                'metadata'    => ['articulo' => $articulo ?? null],
            ]
        );

        return response()->json([
            'redirect' => $checkout->url, // Stripe Checkout URL
        ]);
    }

    public function guestCheckout(Request $request)
    {
        $validar = $request->validate([
            'articulos' => 'required|array|min:1',
            'articulos.*' => 'required|uuid|exists:articulos,uuid',
            'nombre_com' => 'required|string|max:100',
            'direccion_com' => 'required|string|max:100',
            'codigo_postal_com' => 'required|string|max:100',
            'email' => 'required|email',
        ]);

        $articulos = Articulo::whereIn('uuid', $request->articulos)->get();

        if ($articulos->isEmpty()) {
            return response()->json(['error' => 'No se encontraron artículos válidos.'], 422);
        }

        // Stripe requiere los precios en centavos
        $lineItems = [];

        foreach ($articulos as $articulo) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $articulo->nombre,
                    ],
                    'unit_amount' => intval($articulo->precio * 100),
                ],
                'quantity' => 1,
            ];
        }

        $pedido_uuid = Str::uuid();

        $pedido = Pedido::create([
            'uuid' => $pedido_uuid,
            'carrito' => $articulos->toJson(), // ✅ corregido
            'total' => $articulos->sum('precio'), // opcional: guarda el total
            'nombre_com' => $request->nombre_com,
            'direccion_com' => $request->direccion_com,
            'codigo_postal_com' => $request->codigo_postal_com,
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => $request->email,
            'success_url' => route('panel_inicio') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('panel_inicio'),
            'metadata' => [
                'pedido_id' => (string) $pedido_uuid, // CAST explícito
                'email' => $request->email,
            ],
        ]);

        return response()->json([
            'redirect' => $session->url,
        ]);
    }


    public function checkout_sub(Request $request)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        if (! $usuario) {
            abort(401, 'No autenticado');
        }

        $validated = $request->validate([
            'stripe_price_id' => 'nullable|string',      // ej. price_basic_monthly
            'plan_id'         => 'nullable|integer',     // id en tu tabla planes
            'trial_days'      => 'nullable|integer|min:0',
        ]);

        // 1) Resolver el price_id
        // $stripePriceId = $validated['stripe_price_id'] ?? null;
        $stripePriceId = 'price_1SVVmMDKXimljh5PkiWzeZGz';

        if (! $stripePriceId && ! empty($validated['plan_id'])) {
            // Ejemplo: Plan con campo stripe_price_id
            $plan = Plan::findOrFail($validated['plan_id']);
            $stripePriceId = $plan->stripe_price_id;
        }

        if (! $stripePriceId) {
            abort(422, 'Falta stripe_price_id o plan_id');
        }

        $trialDays = $validated['trial_days'] ?? 0;

        // 2) Construir la suscripción
        $builder = $usuario
            ->newSubscription('default', $stripePriceId);

        if ($trialDays > 0) {
            $builder->trialDays($trialDays);
        }

        // Puedes encadenar más cosas si quieres:
        // ->allowPromotionCodes()
        // ->quantity(3)
        // etc.

        // 3) Generar Stripe Checkout para la suscripción
        $checkout = $builder->checkout([
            'success_url' => route('panel_inicio') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('panel_inicio'),
        ]);

        return response()->json([
            'redirect' => $checkout->url,
        ]);
    }

    public function suscripcion_finalizar(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        // Buscar la última suscripción activa/trial del usuario en TU tabla
        $subscription = Suscripcion::where('usuario_id', $user->id)
            ->whereIn('stripe_status', ['active', 'trialing'])
            ->orderByDesc('id')
            ->first();

        if (!$subscription) {
            return response()->json([
                'message' => 'No se encontró ninguna suscripción activa para este usuario',
            ], 404);
        }

        if (!$subscription->stripe_id) {
            return response()->json([
                'message' => 'La suscripción no tiene un stripe_id asociado',
            ], 422);
        }

        // true = cancelar al final del periodo actual, false = cancelación inmediata
        $cancelAtPeriodEnd = $request->boolean('cancel_at_period_end', true);

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            if ($cancelAtPeriodEnd) {
                // Cancelar al final del periodo actual
                $stripeSub = StripeSubscription::update(
                    $subscription->stripe_id,
                    ['cancel_at_period_end' => true]
                );
            } else {
                // Cancelación inmediata
                $stripeSub = StripeSubscription::cancel(
                    $subscription->stripe_id,
                    []
                );
            }

            // --- ACTUALIZAR TU TABLA LOCAL ---
            $subscription->stripe_status = $stripeSub->status; // ejemplo: 'active', 'canceled', 'incomplete'

            // Guardamos la fecha de fin si existe
            if (!empty($stripeSub->current_period_end)) {
                $subscription->ends_at = Carbon::createFromTimestamp($stripeSub->current_period_end);
            } else {
                $subscription->ends_at = null; // Stripe a veces la quita en cancelación inmediata
            }

            // Si tu tabla tiene el campo cancel_at_period_end
            if ($subscription->isFillable('cancel_at_period_end')) {
                $subscription->cancel_at_period_end = (bool) $stripeSub->cancel_at_period_end;
            }

            $subscription->save();

            return response()->json([
                'message' => $cancelAtPeriodEnd
                    ? 'Suscripción marcada para cancelación al final del periodo actual'
                    : 'Suscripción cancelada inmediatamente',
                'status'  => $subscription->stripe_status,
                'ends_at' => $subscription->ends_at,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error al cancelar suscripción en Stripe', [
                'usuario_id'      => $user->id,
                'subscription_id' => $subscription->id,
                'stripe_id'       => $subscription->stripe_id,
                'error'           => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'No se pudo cancelar la suscripción. Revisa los logs.',
            ], 500);
        }
    }
}
