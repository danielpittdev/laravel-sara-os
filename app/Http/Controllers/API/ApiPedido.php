<?php

namespace App\Http\Controllers\API;

use App\Models\Pedido;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ApiPedido extends Controller
{
    // Store
    public function store(Request $request): JsonResponse
    {
        $validacion = $request->validate([
            'articulo_id' => 'required|uuid|exists:articulos,uuid',
            'total' => 'required|string',
            'nombre_com' => 'required|string',
            'direccion_com' => 'required|string',
            'codigo_postal_com' => 'required|string'
        ]);

        $validacion['uuid'] = Str::uuid();
        $pedido = Pedido::create($validacion);

        // Aquí podrías agregar validaciones reales
        return response()->json([
            'mensaje' => 'Pedido creado exitosamente',
            'datos' => [],
            'success' => true,
        ], 201);
    }

    // Store
    public function update($id, Request $request): JsonResponse
    {
        try {
            $pedido = Pedido::whereUuid($id)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Pedido no encontrado',
                'success' => false,
            ], 404);
        }

        $validacion = $request->validate([
            'articulo_id' => 'required|uuid|exists:articulos,uuid',
            'total' => 'required|string',
            'nombre_com' => 'required|string',
            'direccion_com' => 'required|string',
            'codigo_postal_com' => 'required|string'
        ]);

        $pedido = Pedido::create($validacion);

        // Aquí podrías agregar validaciones reales
        return response()->json([
            'mensaje' => 'Pedido actualizado exitosamente',
            'datos' => [],
            'success' => true,
        ], 201);
    }
}
