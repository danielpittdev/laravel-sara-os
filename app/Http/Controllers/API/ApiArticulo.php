<?php

namespace App\Http\Controllers\API;

use App\Models\Articulo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ApiArticulo extends Controller
{
    // Store
    public function store(Request $request): JsonResponse
    {
        $validacion = $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|string',
            'stock' => 'required|string',
        ]);

        $validacion['uuid'] = Str::uuid();
        $articulo = Articulo::create($validacion);

        // Mail::send('emails.avisos.registro', [
        //     'user' => $articulo,
        // ], function ($message) use ($articulo) {
        //     $message->to($articulo->email, $articulo->nombre . ' ' . $articulo->apellido)
        //         ->subject('Registro completo');
        // });

        // Aquí podrías agregar validaciones reales
        return response()->json([
            'mensaje' => 'Articulo creado exitosamente',
            'datos' => [],
            'success' => true,
        ], 201);
    }

    // Store
    public function update($id, Request $request): JsonResponse
    {
        try {
            $articulo = Articulo::whereUuid($id)->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Articulo no encontrado',
                'success' => false,
            ], 404);
        }

        $validacion = $request->validate([
            'nombre' => 'sometimes|string',
            'descripcion' => 'sometimes|string',
            'precio' => 'sometimes|string',
            'stock' => 'sometimes|string',
        ]);

        $articulo->update($validacion);

        // Aquí podrías agregar validaciones reales
        return response()->json([
            'mensaje' => 'Articulo actualizado exitosamente',
            'datos' => [],
            'success' => true,
        ], 201);
    }
}
