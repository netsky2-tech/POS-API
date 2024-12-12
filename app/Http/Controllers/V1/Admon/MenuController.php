<?php

namespace App\Http\Controllers\V1\Admon;


use App\Http\Controllers\V1\Controller;
use App\Http\Resources\Admon\MenuResource;
use App\Models\Admon\Action;
use App\Models\Admon\Permission;
use App\Repositories\Interfaces\Admon\MenuRepositoryInterface;

class MenuController extends Controller
{
    protected $menuRepository;
    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * actions: permisos sobre acciones segun rol
     * permissions: valida si existe el permiso
     * @author octaviom
     */

    public function hasMenuPermission($roleId, $menuId)
    {
        $actions = Action::where('menu_id', $menuId)->pluck('id');

        $permissions = Permission::whereIn('action_id', $actions)
            ->where('role_id', $roleId)
            ->exists();

        return $permissions;
    }


    /**
     * @OA\Get(
     *     path="/api/menus/get-all",
     *     summary="Obtener todos los menus",
     *     description="Devuelve los menús del sistema",
     *     tags={"Menus"},
     *     @OA\Response(
     *         response=200,
     *         description="Menus del sistema",
     *         @OA\JsonContent(ref="#/components/schemas/Menus")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Menus no encontrados"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */

    public function getAll()
    {
        return MenuResource::collection($this->menuRepository->getAll());
    }
}
