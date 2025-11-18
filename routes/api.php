<?php

use App\Http\Controllers\Controller;

# Controladores
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\API\ApiUsuario;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\StripeWebhookController;

Route::prefix('auth')->middleware('web')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('post_login');
    Route::post('/registro', [AuthController::class, 'registro'])->name('post_registro');
    Route::post('/recuperar', [AuthController::class, 'recuperar'])->name('post_recuperar');
    Route::post('/restablecer', [AuthController::class, 'resetear'])->name('post_resetear');
    Route::post('/logout', [AuthController::class, 'logout'])->name('cerrar_sesion');
});

// API V1
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    /* TEST */
    Route::post('/test', [ApiController::class, 'test'])->name('api_test');

    // Stripe
    Route::post('/checkout', [StripeController::class, 'checkout'])->name('api_checkout');
    Route::post('/checkout/sub', [StripeController::class, 'checkout_sub'])->name('api_checkout_sub');

    // Usuarios
    Route::apiResource('usuarios', ApiUsuario::class);
});

// Stripe Webhook
Route::post('webhook', [StripeWebhookController::class, 'handleWebhook']);
