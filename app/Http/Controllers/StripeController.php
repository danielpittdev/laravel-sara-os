<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Usuario;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $producto = Producto::findOrFail($validated['producto_id']);
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
                'metadata'    => ['order_id' => $pedido->id ?? null],
            ]
        );

        return response()->json([
            'url' => $checkout->url, // Stripe Checkout URL
        ]);
    }

    /**
     * CHECKOUT SUSCRIPCIÓN con Stripe Checkout.
     *
     * - Recibe price_id directamente o plan_id para buscarlo en BD.
     * - Crea suscripción 'default' al price indicado.
     */
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
        $stripePriceId = 'price_1Ryb8qDby92PFs9n7ED8uRm0';

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
            'url' => $checkout->url,
        ]);
    }
}
