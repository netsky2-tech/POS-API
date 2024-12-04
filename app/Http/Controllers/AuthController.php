<?php

namespace App\Http\Controllers;

use App\Services\Admon\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     title="API de Autenticación",
 *     version="1.0.0",
 *     description="API para gestionar el registro, login, autenticación, y cierre de sesión de los usuarios utilizando JWT.",
 *     @OA\Contact(
 *         email="soporte@tudominio.com"
 *     )
 * )
 */

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */

class AuthController extends Controller
{
    protected AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Registrar un nuevo usuario",
     *     description="Crea un nuevo usuario y lo registra en el sistema.",
     *     operationId="register",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name", "email", "password"},
     *                 @OA\Property(property="name", type="string", description="Nombre del usuario"),
     *                 @OA\Property(property="full_name", type="string", description="Nombre completo"),
     *                 @OA\Property(property="email", type="string", format="email", description="Correo electrónico del usuario"),
     *                 @OA\Property(property="password", type="string", description="Contraseña del usuario"),
     *                 @OA\Property(property="company_id", type="integer", description="ID de la empresa"),
     *                 @OA\Property(property="branch_id", type="integer", description="ID de la sucursal")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado con éxito.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario creado con éxito.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la validación de datos.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="object"),
     *             @OA\Property(property="message", type="string", example="Ocurrió un error con los datos ingresados, favor valide e intente nuevamente.")
     *         )
     *     )
     * )
     */
    public function register(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'message' => "Ocurrió un error con los datos ingresados, favor valide e intente nuevamente."
            ], 400);
        }

        try {
            $user = $this->authService->register($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado con éxito.'
            ], 201);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage(), 'message' => 'Ocurrio un error registrando el usuario.'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Iniciar sesión y generar un JWT",
     *     description="Autentica al usuario y devuelve un JWT para las siguientes peticiones.",
     *     operationId="login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"email", "password"},
     *                 @OA\Property(property="email", type="string", format="email", description="Correo electrónico del usuario"),
     *                 @OA\Property(property="password", type="string", description="Contraseña del usuario")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso.",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Ha iniciado sesión correctamente, bienvenido."),
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwiZXhwIjoxNjg1MzI4NjA0fQ.4h1d7E4..")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la validación de datos.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="object"),
     *             @OA\Property(property="message", type="string", example="Ha ocurrido un error con los datos ingresados, por favor valide e intente nuevamente.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Credenciales incorrectas")
     *         )
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {

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

        try {
            $token = $this->authService->login($request->only('email', 'password'), $request->ip());

            return response()->json([
                'success' => true,
                'message' => 'Ha iniciado sesión correctamente, bienvenido.',
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'No se pudo crear el token', 'error' => $e->getMessage(), 'success' => false], 401);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/auth/user",
     *     summary="Obtener información del usuario autenticado",
     *     description="Devuelve los datos del usuario autenticado.",
     *     operationId="getUser",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Datos del usuario autenticado.",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", example="juan@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al obtener los datos del usuario.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El usuario no se encuentra autenticado")
     *         )
     *     )
     * )
     */
    public function user(Request $request): JsonResponse
    {
        try {
            $user = $this->authService->getUser();
            return response()->json($user);
        } catch (UserNotDefinedException $e) {
            return response()->json(['message' => 'El usuario no se encuentra autenticado'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Cerrar sesión",
     *     description="Invalidar el token JWT y cerrar la sesión del usuario.",
     *     operationId="logout",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Sesión cerrada correctamente.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sesión cerrada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al cerrar sesión.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No se pudo cerrar sesión")
     *         )
     *     )
     * )
     */

    public function logout(): JsonResponse
    {
        try {
            $this->authService->logout();
            return response()->json(['message' => 'Sesión cerrada correctamente']);
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token expirado. Sesión cerrada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo cerrar sesión: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     summary="Refrescar el token JWT",
     *     description="Renovar el token JWT utilizando el refresh token.",
     *     operationId="refresh",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Token renovado correctamente.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token renovado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Refresh token no proporcionado.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Refresh token no proporcionado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al renovar el token.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No se pudo renovar el token")
     *         )
     *     )
     * )
     */
    public function refresh(Request $request): JsonResponse
    {
        try {

            $refresh_token = $this->authService->refreshToken();
            return response()->json([
                'message' => 'Refresh token generado',
                'token' => $refresh_token
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo renovar el token'], 500);
        }
    }
}
