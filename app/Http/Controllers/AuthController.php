<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Login de usuario
    public function login(Request $request)
    {
        try {
            // Validación inicial de campos
            $credentials = $request->validate([
                'email'    => 'required|email',
                'password' => 'required|string',
            ], [
                'email.required' => 'El correo electrónico es obligatorio',
                'email.email' => 'El correo electrónico debe ser válido',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            ]);

            // Intento de login
            if (!Auth::attempt($credentials)) {
                // Devuelve errores específicos por campo si no coincide
                return response()->json([
                    'response_code' => 401,
                    'status'        => 'error',
                    'mensaje'       => 'Credenciales incorrectas',
                    'errores'        => [
                        'email'    => ['No se encontró el usuario'],
                    ],
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            // Opcional: cookie JWT
            setcookie('jwt', $token, time() + 3600, '/'); // 1 hora

            // Regenera sesión
            $request->session()->regenerate();

            return response()->json([
                'response_code' => 200,
                'status'        => 'success',
                'mensaje'       => 'Login correcto',
                'user_info'     => [
                    'id'     => $user->id,
                    'nombre' => $user->nombre,
                    'email'  => $user->email,
                ],
                'token'       => $token,
                'token_type'  => 'Bearer',
                'redirect'    => '/panel',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'response_code' => 422,
                'status'        => 'error',
                'mensaje'       => 'Comprueba los datos',
                'errores'        => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());

            return response()->json([
                'response_code' => 500,
                'status'        => 'error',
                'mensaje'       => 'Ocurrió un error al iniciar sesión. Intenta de nuevo.',
            ], 500);
        }
    }

    // Registro de usuario
    public function registro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'apellido.required' => 'El apellido es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe ser válido',
            'email.unique' => 'Este correo electrónico ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'mensaje' => 'Datos inválidos',
                    'errores' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $user = Usuario::create([
            'nombre' => ucfirst($request->nombre),
            'apellido' => ucfirst($request->apellido),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->expectsJson()) {
            // Para API: generar JWT token
            try {
                Mail::send('emails.avisos.registro', [
                    'user' => $user,
                ], function ($message) use ($user) {
                    $message->to($user->email, $user->nombre . ' ' . $user->apellido)
                        ->subject('Registro completo');
                });

                return response()->json([
                    'mensaje' => 'Registro exitoso',
                    'redirect' => route('login')
                ], 201);
            } catch (JWTException $e) {
                return response()->json(['mensaje' => 'Error al generar token'], 500);
            }
        } else {
            // Para WEB: usar sesiones
            Auth::login($user);
            return redirect()->route('panel_inicio');
        }
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if ($user) {
                $user->tokens()->delete();

                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return response()->json([
                    'response_code' => 200,
                    'status'        => 'success',
                    'mensaje'       => 'Se ha cerrado la sesión',
                    'redirect' => '/login',
                ]);
            }

            return response()->json([
                'response_code' => 401,
                'status'        => 'error',
                'mensaje'       => 'User not authenticated',
            ], 401);
        } catch (\Exception $e) {
            Log::error('Logout Error: ' . $e->getMessage());

            return response()->json([
                'response_code' => 500,
                'status'        => 'error',
                'mensaje'       => 'An error occurred during logout',
            ], 500);
        }
    }

    // Recuperación
    public function recuperar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:usuarios,email',
        ], [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe ser válido',
            'email.exists' => 'No encontramos un usuario con este correo electrónico',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'mensaje' => 'Datos inválidos',
                    'errores' => $validator->errors()
                ], 401);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Generar token único
        $token = Str::random(60);

        // Guardar token en la base de datos
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Obtener el usuario
        $user = Usuario::where('email', $request->email)->first();

        // Enviar correo con el enlace de recuperación
        try {
            Mail::send('emails.password-reset', [
                'user' => $user,
                'token' => $token,
                'url' => route('resetear', $token)
            ], function ($message) use ($user) {
                $message->to($user->email, $user->nombre . ' ' . $user->apellido)
                    ->subject('Recuperación de Contraseña');
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'mensaje' => 'Enlace de recuperación enviado exitosamente'
                ]);
            }

            return back()->with('status', 'Se ha enviado el enlace de recuperación a tu correo electrónico.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'mensaje' => 'Error al enviar el correo de recuperación'
                ], 500);
            }

            return back()->with('error', 'Error al enviar el correo de recuperación.');
        }
    }

    // Restablecer
    public function resetear(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:usuarios,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'token.required' => 'Token de recuperación requerido',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe ser válido',
            'email.exists' => 'No encontramos un usuario con este correo electrónico',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'mensaje' => 'Datos inválidos',
                    'errores' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Buscar el token en la base de datos
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            if ($request->expectsJson()) {
                return response()->json([
                    'mensaje' => 'Token de recuperación inválido'
                ], 400);
            }
            return back()->with('error', 'Token de recuperación inválido.');
        }

        // Verificar que el token coincida
        if (!Hash::check($request->token, $passwordReset->token)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'mensaje' => 'Token de recuperación inválido'
                ], 400);
            }
            return back()->with('error', 'Token de recuperación inválido.');
        }

        // Verificar que el token no haya expirado (1 hora)
        $tokenAge = Carbon::parse($passwordReset->created_at);
        if ($tokenAge->addHour()->isPast()) {
            // Eliminar token expirado
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            if ($request->expectsJson()) {
                return response()->json([
                    'mensaje' => 'El token de recuperación ha expirado'
                ], 400);
            }
            return back()->with('error', 'El token de recuperación ha expirado.');
        }

        // Actualizar la contraseña del usuario
        $user = Usuario::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Eliminar el token usado
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'mensaje' => 'Contraseña restablecida exitosamente'
            ]);
        }

        return redirect()->route('login')->with('status', 'Tu contraseña ha sido restablecida exitosamente.');
    }
}
