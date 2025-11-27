<?php

namespace App\Http\Controllers\API;

use App\Models\Usuario;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ApiUsuario extends Controller
{
    // Crear usuario (POST)
    public function store(Request $request): JsonResponse
    {
        $validacion = $request->validate([
            'nombre' => 'required|max:30',
            'apellido' => 'required|max:50',
            'email' => 'required|email',
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Str::random(10)
        ]);

        Mail::send('email.avisos.registro', [
            'user' => $usuario,
        ], function ($message) use ($usuario) {
            $message->to($usuario->email, $usuario->nombre . ' ' . $usuario->apellido)
                ->subject('Registro completo');
        });

        // Aquí podrías agregar validaciones reales
        return response()->json([
            'mensaje' => 'Usuario creado exitosamente',
            'datos' => [],
            'success' => true,
        ], 201);
    }

    // Actualizar usuario (PUT/PATCH)
    public function update(Request $request, string $id): JsonResponse
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json([
                'mensaje' => 'Usuario no encontrado',
                'success' => false,
            ], 404);
        }

        if ($usuario->id !== Auth::id()) {
            return response()->json([
                'mensaje' => 'No tienes permisos para actualizar este usuario',
                'success' => false,
            ], 403);
        }

        // Cambio de contraseña
        if ($request->filled('current_password')) {
            $validated = $request->validate([
                'current_password' => 'required|string|min:8|max:20',
                'password' => 'required|string|min:8|max:20|confirmed',
            ], [
                'current_password.required' => 'La contraseña actual es obligatoria',
                'password.required' => 'La nueva contraseña es obligatoria',
                'password.min' => 'Debe contener al menos 8 caracteres',
                'password.max' => 'Debe contener entre 8 y 20 caracteres',
                'password.confirmed' => 'La confirmación de la contraseña no coincide',
            ]);

            if (!Hash::check($validated['current_password'], $usuario->password)) {
                return response()->json([
                    'mensaje' => 'La contraseña actual no es correcta',
                    'success' => false,
                ], 422);
            }

            $usuario->update([
                'password' => Hash::make($validated['password']),
            ]);

            // Aviso por email
            Mail::send('email.avisos.cambio-contrasena', ['user' => $usuario], function ($message) use ($usuario) {
                $message->to($usuario->email, $usuario->nombre . ' ' . $usuario->apellido)
                    ->subject('Cambio de contraseña');
            });

            return response()->json([
                'mensaje' => 'Contraseña actualizada correctamente',
                'datos' => ['id' => $usuario->id],
                'success' => true,
            ], 200);
        }

        // Actualizar nombre/apellido
        if ($request->filled('nombre') || $request->filled('apellido')) {
            $validated = $request->validate([
                'nombre' => 'required|string',
                'apellido' => 'required|string',
                'avatar' => 'sometimes|mimes:png,jpeg,jpg|max:5024',
            ], [
                'nombre.required' => 'El nombre es obligatorio',
                'apellido.required' => 'El apellido es obligatorio',
                'avatar.mimes' => 'Formato no compatible',
            ]);

            // Capitalizar nombre y apellido
            $validated['nombre'] = ucfirst($validated['nombre']);
            $validated['apellido'] = ucfirst($validated['apellido']);

            // Procesar avatar si se sube
            if ($request->hasFile('avatar')) {
                // Eliminar anterior si existe
                if ($usuario->avatar && Storage::exists($usuario->avatar)) {
                    Storage::delete($usuario->avatar);
                }

                // Guardar el nuevo avatar
                $ruta = $request->file('avatar')->store('avatars'); // Guarda en storage/app/avatars
                $validated['avatar'] = $ruta;
            }

            // Actualizar usuario
            $usuario->update($validated);

            return response()->json([
                'mensaje' => 'Datos del usuario actualizados correctamente',
                'datos' => $validated,
                'success' => true,
            ]);
        }

        return response()->json([
            'mensaje' => 'No se realizaron cambios',
            'datos' => null,
            'success' => true,
        ], 200);
    }
}
