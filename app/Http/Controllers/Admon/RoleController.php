<?php

namespace App\Http\Controllers\Admon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admon\RoleRequest;
use App\Http\Resources\Admon\RoleResource;
use App\Services\Admon\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    Protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(): AnonymousResourceCollection
    {
        $roles = $this->roleService->getAllRoles();

        return RoleResource::collection($roles);
    }

    public function store(RoleRequest $request): RoleResource
    {
        $role = $this->roleService->createRole($request->validated());

        return new RoleResource($role);
    }

    public function show($id): RoleResource
    {
        $role = $this->roleService->getRoleById($id);

        if($role){

            return new RoleResource($role);
        }
        return response()->json(['message' => 'No se pudo encontrar el rol seleccionado.'], 404);
    }

    public function update(RoleRequest $request, $id): RoleResource
    {
        $role = $this->roleService->updateRole($id, $request->validated());

        if ($role) {
            return new RoleResource($role);
        }

        return response()->json(['message' => 'No se pudo encontrar el rol para actualizar.'], 404);
    }

    public function destroy($id): JsonResponse
    {
        if ($this->roleService->deleteRole($id)) {
            return response()->json(['message' => 'Rol eliminado correctamente.']);
        }

        return response()->json(['message' => 'No se pudo eliminar el rol seleccionado.'], 404);
    }
}
