<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Stripe\Webhook;
use App\Models\Pedido;
use App\Models\Usuario;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
                $metadata = $object->metadata?->toArray() ?? [];

                Log::info('Metadata decodificado', $metadata);

                if (!isset($metadata['pedido_id'])) {
                    Log::warning('checkout.session.completed sin pedido_id en metadata');
                    break;
                }

                $pedido_id = $metadata['pedido_id'];
                $pedido = Pedido::where('uuid', $pedido_id)->first();

                if (!$pedido) {
                    Log::warning("Pedido no encontrado con UUID={$pedido_id}");
                    break;
                }

                $pedido->update([
                    'estado' => 'procesado'
                ]);

                $email = $metadata['email'] ?? null;

                if ($email) {
                    Mail::send('emails.avisos.compra', [
                        'pedido' => $pedido,
                        'carrito' => json_decode($pedido->carrito),
                    ], function ($message) use ($pedido, $email) {
                        $message->to($email, $pedido->nombre_com)
                            ->subject('Compra realizada');
                    });
                } else {
                    Log::warning("Email no encontrado en metadata para pedido {$pedido_id}");
                }


                Log::info("Pedido marcado como procesado. UUID={$pedido_id}");
                break;

            case 'invoice.payment_succeeded':
                // $object es \Stripe\Invoice
                if ($usuario) {
                    $amount   = $object->amount_paid ?? 0;     // en centavos
                    $currency = $object->currency ?? 'eur';
                    $invId    = $object->id ?? null;

                    // Ejemplo de registro rápido:
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
