<?php

use App\Http\Controllers\Controller;

# Controladores
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\API\ApiUsuario;
use App\Http\Controllers\AuthController;

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

    // Usuarios
    Route::apiResource('usuarios', ApiUsuario::class);
});
