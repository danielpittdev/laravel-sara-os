<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PaymentStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = Auth::user();

        // Comprueba que el usuario tenga al menos una suscripción activa
        $suscripcionActiva = $usuario->suscripcion()
            ->where('stripe_status', 'active')
            ->exists();

        if ($suscripcionActiva) {
            return $next($request);
        }

        // Ninguna suscripción activa → redirige a la página de error
        return redirect(route('panel_premium'));
    }
}
