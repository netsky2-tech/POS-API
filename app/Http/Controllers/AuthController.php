<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
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
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'message' => "Ocurrió un error con los datos ingresados, favor valide e intente nuevamente."
            ], 400);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'company_id' => $request->company_id,
            'branch_id' => $request->branch_id,
            'password' => bcrypt($request->password),
        ]);


        return response()->json([
            'message' => 'Usuario creado con éxito.'
        ], 201);
    }

    // Login: Generar y devolver el JWT
    public function login(Request $request): JsonResponse
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
        try {
            if (!$token = auth()->attempt($credentials)) {
                Cache::increment('login_attempts_' . $request->ip());
                return response()->json(['error' => 'Credenciales incorrectas'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }

        Cache::forget('login_attempts_' . $request->ip());

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }


    public function user(Request $request): JsonResponse
    {
        try {
            return response()->json(auth()->user());
        } catch (UserNotDefinedException $e) {
            return response()->json(['message' => 'El usuario no se encuentra autenticado'], 500);
        }
    }

    // Logout: Invalidar el token
    public function logout(Request $request): JsonResponse
    {
        try {
            auth()->logout();
            return response()->json(['message' => 'Sesión cerrada correctamente']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo cerrar sesión'], 500);
        }
    }

    public function refresh(Request $request): JsonResponse
    {
        try {
            return $this->respondWithToken(auth()->refresh());
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo refrescar el token de sesion.'], 500);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 200);
    }
}
