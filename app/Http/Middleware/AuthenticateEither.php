<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateEither
{
    public function handle($request, Closure $next)
    {
        // si no, probamos con la sesión web
        if (Auth::guard('web')->check()) {
            Auth::shouldUse('web');
            return $next($request);
        }

        // primero intentamos con Sanctum (Bearer o cookie)
        if (Auth::guard('sanctum')->check()) {
            Auth::shouldUse('sanctum');
            return $next($request);
        }

        // ninguno funciona → 401
        return abort(401, 'Unauthenticated');
    }
}
