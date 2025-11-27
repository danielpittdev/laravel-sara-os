<?php

use Illuminate\Support\Facades\Route;

# Controladores
use App\Http\Controllers\WebController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\SingleController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\RecursosController;

// WEB
Route::get('/', [WebController::class, 'inicio'])->name('web_inicio');
Route::get('/vitalic', [WebController::class, 'vitalic'])->name('web_vitalic');

// AUTH - Rutas web
Route::get('/login', [WebController::class, 'login'])->name('login');
Route::get('/registro', [WebController::class, 'registro'])->name('registro');
Route::get('/recuperar', [WebController::class, 'recuperar'])->name('recuperar');
Route::get('/resetear/{token}', [WebController::class, 'resetear'])->name('resetear');

// Procesar compra
Route::post('/checkout', [StripeController::class, 'guestCheckout'])->name('api_checkout_guest');

// PANEL - Protegido con autenticación
Route::prefix('panel')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [PanelController::class, 'inicio'])->name('panel_inicio');
    Route::get('/usuarios', [PanelController::class, 'usuarios'])->name('panel_usuarios');
    Route::get('/premium', [PanelController::class, 'premium'])->name('panel_premium');
    Route::get('/ajustes', [PanelController::class, 'ajustes'])->name('panel_ajustes');

    // Paneles singulares 
    Route::prefix('single')->group(function () {
        Route::get('/usuario/{id}', [SingleController::class, 'usuario'])->name('single_usuario');
    });
});

// Rutas de recursos
Route::prefix('res')->middleware('either')->group(function () {
    Route::post('/cerrar-sesion', [AuthController::class, 'logout'])->name('cerrar_sesion');
});
