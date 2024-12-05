<?php

namespace App\Http\Controllers\V1\Admon;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\Admon\RoleRequest;
use App\Http\Resources\Admon\RoleResource;
use App\Models\Admon\Role;
use App\Services\Admon\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Role",
 *     type="object",
 *     title="Role",
 *     required={"name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID del rol"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre del rol"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de creación"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de actualización"
 *     )
 * )
 */

class RoleController extends Controller
{
    Protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @OA\Get(
     *     path="/api/roles/index",
     *     summary="Obtener todos los roles",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *          name="per_page",
     *          in="query",
     *          description="Número de roles por página",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              default=15
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de roles",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      ref="#/components/schemas/Role"
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="meta",
     *                  type="object",
     *                  @OA\Property(
     *                      property="current_page",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="per_page",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="total",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="total_pages",
     *                      type="integer"
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="links",
     *                  type="object",
     *                  @OA\Property(
     *                      property="first",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="last",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="prev",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="next",
     *                      type="string"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Parámetros incorrectos"
     *      ),
     *     security={{"bearerAuth": {}}}
     * )
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $filters = $request->only('search');
        $roles = $this->roleService->getAllPaginated($filters, $request->get('per_page', 15));
        return RoleResource::collection($roles);
    }

    /**
     * @OA\Post(
     *     path="/api/roles/create",
     *     summary="Crear un nuevo rol",
     *     tags={"Roles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RoleRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rol creado",
     *         @OA\JsonContent(ref="#/components/schemas/Role")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function store(RoleRequest $request): RoleResource
    {
        $role = $this->roleService->createRole($request->validated());
        return new RoleResource($role);
    }

    /**
     * @OA\Get(
     *     path="/api/roles/show/{id}",
     *     summary="Obtener un rol por ID",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del rol",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del rol",
     *         @OA\JsonContent(ref="#/components/schemas/Role")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rol no encontrado"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function show($id): RoleResource
    {
        $role = $this->roleService->getRoleById($id);

        if($role){

            return new RoleResource($role);
        }
        return response()->json(['message' => 'No se pudo encontrar el rol seleccionado.'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/roles/update/{role}",
     *     summary="Actualizar un rol existente",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="role",
     *         in="path",
     *         description="ID del rol",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RoleRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rol actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Role")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rol no encontrado"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function update(RoleRequest $request, Role $role): RoleResource
    {
        $role = $this->roleService->updateRole($role, $request->validated());

        return new RoleResource($role);
    }

    /**
     * @OA\Delete(
     *     path="/api/roles/delete/{role}",
     *     summary="Eliminar un rol",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del rol",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rol eliminado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Role deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rol no encontrado"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function destroy(Role $role): \Illuminate\Http\Response
    {
        $this->roleService->deleteRole($role);
        return response()->noContent();
    }
}
