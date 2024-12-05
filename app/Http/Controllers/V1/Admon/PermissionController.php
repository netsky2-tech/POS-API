<?php

namespace App\Http\Controllers\Admon;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admon\ActionRepositoryInterface;
use App\Repositories\Interfaces\Admon\MenuRepositoryInterface;
use App\Repositories\Interfaces\Admon\ModuleRepositoryInterface;
use App\Repositories\Interfaces\Admon\PermissionRepositoryInterface;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{

    protected ModuleRepositoryInterface $moduleRepository;
    protected MenuRepositoryInterface $menuRepository;
    protected ActionRepositoryInterface $actionRepository;
    protected PermissionRepositoryInterface $permissionRepository;

    public function __construct(
        ModuleRepositoryInterface     $moduleRepository,
        MenuRepositoryInterface       $menuRepository,
        ActionRepositoryInterface     $actionRepository,
        PermissionRepositoryInterface $permissionRepository
    )
    {
        $this->moduleRepository = $moduleRepository;
        $this->menuRepository = $menuRepository;
        $this->actionRepository = $actionRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/permissions/{roleId}",
     *     summary="Obtiene los permisos por módulo",
     *     description="Devuelve los módulos, menús y acciones a los que un rol tiene acceso.",
     *     tags={"Permissions"},
     *     @OA\Parameter(
     *         name="roleId",
     *         in="path",
     *         description="ID del rol para consultar permisos",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de permisos por módulo",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="module",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Ventas"),
     *                     @OA\Property(
     *                         property="menus",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="Facturación"),
     *                             @OA\Property(
     *                                 property="actions",
     *                                 type="array",
     *                                 @OA\Items(
     *                                     type="object",
     *                                     @OA\Property(property="id", type="integer", example=1),
     *                                     @OA\Property(property="name", type="string", example="Registrar")
     *                                 )
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rol no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Rol no encontrado")
     *         )
     *     )
     * )
     */

    public function getModulePermissions($roleId): JsonResponse
    {
        // Obtener todos los módulos
        $modules = $this->moduleRepository->getAll();
        $modulePermissions = [];

        foreach ($modules as $module) {
            $moduleData = [
                'id' => $module->id,
                'name' => $module->name,
                'menus' => []
            ];

            // Obtener los menús relacionados al módulo
            $menus = $this->menuRepository->getByModuleId($module->id);

            foreach ($menus as $menu) {
                // Verificar si el rol tiene permisos para las acciones del menú
                $actions = $this->actionRepository->getByMenuId($menu->id);
                $allowedActions = [];

                foreach ($actions as $action) {
                    // Verificar si el rol tiene permiso para la acción
                    if ($this->permissionRepository->existsForRoleAndAction($roleId, $action->id)) {
                        $allowedActions[] = [
                            'id' => $action->id,
                            'name' => $action->name,
                        ];
                    }
                }

                // Si hay acciones permitidas, incluir el menú
                if (!empty($allowedActions)) {
                    $moduleData['menus'][] = [
                        'id' => $menu->id,
                        'name' => $menu->name,
                        'actions' => $allowedActions,
                    ];
                }
            }

            // Si el módulo tiene menús permitidos, agregarlo al resultado
            if (!empty($moduleData['menus'])) {
                $modulePermissions[] = ['module' => $moduleData];
            }
        }

        return response()->json($modulePermissions);
    }
}
