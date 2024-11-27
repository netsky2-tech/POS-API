<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\JWT;

class AuthenticateJWT
{
    /**
     * Get the JWT Token from cookie and validate claims
     */
    public function handle($request, Closure $next)
    {
        // Obtener el token desde la cookie
        $token = $request->cookies->all();
        Log::info('Token obtenido:');
        Log::info($token);

        if (!$token) {
            return response()->json(['message' => 'Token no proporcionado.'], 401);
        }

        try {
            $user = JWTAuth::setToken($token)->authenticate();

            // Verificar la validez del token
            if (!JWTAuth::check()) {
                return response()->json(['message' => 'Token inválido o expirado'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Error al procesar el token'], 401);
        }

        // Permitir la continuación de la solicitud
        return $next($request);
    }
}
