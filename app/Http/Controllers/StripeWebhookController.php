<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierWebhookController;

class StripeWebhookController extends CashierWebhookController
{
    /**
     * Webhook único con switch por tipo de evento.
     */
    public function handleWebhook(Request $request)
    {
        $endpointSecret = config('services.stripe.webhook_secret');

        $payload    = $request->getContent();
        $sigHeader  = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            Log::warning('Stripe webhook: payload inválido');
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::warning('Stripe webhook: firma inválida');
            return response('Invalid signature', 400);
        }

        $type   = $event->type;
        $object = $event->data->object;

        // Intentar sacar el customer para localizar al usuario
        $customerId = $object->customer ?? ($object->customer_id ?? null);
        $usuario    = $customerId
            ? Usuario::where('stripe_id', $customerId)->first()
            : null;

        // 🔀 AQUÍ tu lógica central, TODO en un switch
        switch ($type) {

            case 'checkout.session.completed':
                // $object es \Stripe\Checkout\Session
                $mode     = $object->mode; // 'payment' o 'subscription'
                $metadata = (array) ($object->metadata ?? []);

                if ($usuario) {
                    if ($mode === 'payment') {
                        // ✅ PAGO ÚNICO COMPLETADO
                        // Ejemplo: marcar pedido como pagado
                        //
                        // $orderId = $metadata['order_id'] ?? null;
                        // Pedido::where('id', $orderId)->update([
                        //     'estado'  => 'pagado',
                        //     'paid_at' => now(),
                        // ]);
                        //
                        Log::info("Pago único OK (checkout.session.completed) usuario={$usuario->id}");
                    } elseif ($mode === 'subscription') {
                        // ✅ SUSCRIPCIÓN creada vía Checkout
                        Log::info("Suscripción vía Checkout completada usuario={$usuario->id}");
                    }
                }
                break;

            case 'invoice.payment_succeeded':
                // $object es \Stripe\Invoice
                if ($usuario) {
                    $amount   = $object->amount_paid ?? 0;     // en centavos
                    $currency = $object->currency ?? 'eur';
                    $invId    = $object->id ?? null;

                    // Ejemplo de registro rápido:
                    // Pago::create([
                    //     'usuario_id'        => $usuario->id,
                    //     'stripe_invoice_id' => $invId,
                    //     'monto'             => $amount / 100,
                    //     'moneda'            => strtoupper($currency),
                    //     'tipo'              => 'suscripcion',
                    //     'pagado_en'         => now(),
                    // ]);

                    Log::info("invoice.payment_succeeded usuario={$usuario->id} invoice={$invId}");
                }
                break;

            case 'invoice.payment_failed':
                if ($usuario) {
                    // Aquí puedes notificar al usuario,
                    // marcar riesgo de cancelación, etc.
                    Log::warning("invoice.payment_failed usuario={$usuario->id}");
                }
                break;

            case 'customer.subscription.deleted':
                if ($usuario) {
                    // Aquí puedes desactivar premium, etc.
                    // $usuario->update(['es_premium' => false]);
                    Log::info("Suscripción CANCELADA usuario={$usuario->id}");
                }
                break;

            case 'charge.refunded':
                if ($usuario) {
                    $chargeId = $object->id ?? null;
                    // Ej: marcar pago/pedido como reembolsado
                    // Pago::where('stripe_charge_id', $chargeId)->update(['estado' => 'reembolsado']);
                    Log::info("charge.refunded usuario={$usuario->id} charge={$chargeId}");
                }
                break;

            default:
                // Todo lo demás lo dejamos solo logueado
                Log::info("Stripe webhook no manejado (switch): {$type}");
        }

        // ⚙️ Dejamos que Cashier haga su magia interna
        // (actualizar tabla subscriptions, payment_methods, etc.)
        return parent::handleWebhook($request);
    }
}
