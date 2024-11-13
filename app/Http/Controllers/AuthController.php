<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function register(Request $request)
    {
        // Validación de los datos de registro
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'message' => "Ocurrió un error con los datos ingresados, favor valide e intente nuevamente."
            ], 400);
        }

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generar el token JWT
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Usuario creado con éxito.',
            'token' => $token
        ]);
    }

    // Login: Generar y devolver el JWT
    public function login(Request $request)
    {
        $attempts = Cache::get('login_attempts_' . $request->ip(), 0);

        if ($attempts >= 5) {
            return response()->json(['message' => 'Demasiados intentos. Inténtalo de nuevo en 10 minutos.'], 429);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'message' => "Ha ocurrido un error con los datos ingresados, por favor valide e intente nuevamente."
            ], 400);
        }

        $credentials = $request->only('email', 'password');
        Log::debug('Attempting login with credentials: ', $credentials);
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                Log::error('JWTAuth attempt failed for credentials: ', $credentials);
                Cache::increment('login_attempts_' . $request->ip());
                return response()->json(['error' => 'Credenciales incorrectas'], 401);
            }
        } catch (JWTException $e) {
            Log::debug('JWTException encountered: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }

        Log::debug('Token generated: ', ['token' => $token]);
        Cache::forget('login_attempts_' . $request->ip());

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer '
        ], 200);
    }


    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // Logout: Invalidar el token
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Sesión cerrada correctamente']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo cerrar sesión'], 500);
        }
    }

    public function refresh(Request $request)
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json(compact('token'));
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo refrescar el token'], 500);
        }
    }
}
