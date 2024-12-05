<?php

namespace App\Http\Controllers\V1\Admon;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\Admon\RoleRequest;
use App\Http\Resources\Admon\RoleResource;
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
     * @return array
     */
    public function index(Request $request): array
    {
        $perPage = $request->get('per_page', 15);

        $roles = $this->roleService->getAllPaginated($perPage);

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
        Log::info($request->validated());
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
     *     path="/api/roles/update/{id}",
     *     summary="Actualizar un rol existente",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
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
    public function update(RoleRequest $request, $id): RoleResource
    {
        $role = $this->roleService->updateRole($id, $request->validated());

        if ($role) {
            return new RoleResource($role);
        }

        return response()->json(['message' => 'No se pudo encontrar el rol para actualizar.'], 404);
    }

    /**
     * @OA\Delete(
     *     path="/api/roles/delete/{id}",
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
    public function destroy($id): JsonResponse
    {
        if ($this->roleService->deleteRole($id)) {
            return response()->json(['message' => 'Rol eliminado correctamente.']);
        }

        return response()->json(['message' => 'No se pudo eliminar el rol seleccionado.'], 404);
    }
}
