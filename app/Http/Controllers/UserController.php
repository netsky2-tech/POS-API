<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *     title="API de Usuarios",
 *     version="1.0.0",
 *     description="Documentación de la API de usuarios para gestionar los recursos",
 *     @OA\Contact(
 *         email="support@tuempresa.com"
 *     )
 * )
 */

 /**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     in="header",
 *     description="Token JWT necesario para acceder a la API"
 * )
 */

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="id", type="integer", description="ID del usuario"),
 *     @OA\Property(property="name", type="string", description="Nombre del usuario"),
 *     @OA\Property(property="email", type="string", description="Correo electrónico del usuario"),
 *     @OA\Property(property="password", type="string", description="Contraseña del usuario"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Fecha de actualización")
 * )
 */

class UserController extends Controller
{


    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Obtener lista de usuarios",
     *     tags={"Usuarios"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */

    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $repository){

        $this->userRepository = $repository;
    }


    public function index(): \Illuminate\Http\JsonResponse
    {
        $users = $this->userRepository->getAllUsers();
        return response()->json($users);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Crear un nuevo usuario",
     *     tags={"Usuarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }
}
