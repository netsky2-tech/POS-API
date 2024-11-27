<?php

namespace App\Http\Controllers\Admon;

use App\Http\Controllers\Controller;
use App\Models\Admon\Action;
use App\Models\Admon\Menu;
use App\Models\Admon\Module;
use App\Models\Admon\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function hasModulePermission($roleId, $moduleId)
    {
        // Obtener las acciones dentro del módulo
        $actions = Action::whereHas('menu', function($query) use ($moduleId) {
            $query->where('module_id', $moduleId);
        })->pluck('id');

        // Verificar si el rol tiene permisos sobre esas acciones
        return Permission::whereIn('action_id', $actions)
            ->where('role_id', $roleId)
            ->exists();
    }

    public function hasMenuPermission($roleId, $menuId)
    {
        // Verificar si el rol tiene permisos sobre las acciones de ese menú
        $actions = Action::where('menu_id', $menuId)->pluck('id');

        return Permission::whereIn('action_id', $actions)
            ->where('role_id', $roleId)
            ->exists();
    }

    public function hasActionPermission($roleId, $actionId)
    {
        // Verificar si el rol tiene el permiso sobre esa acción
        return Permission::where('action_id', $actionId)
            ->where('role_id', $roleId)
            ->exists();
    }

    /**
     * modulePermission: permisos de cada action, menu y module que tiene el usuario
     * @author octaviom
     */

    public function getModulePermissions($roleId): \Illuminate\Http\JsonResponse
    {
         // Obtener todos los módulos
         $modules = Module::all();

         $modulePermissions = [];

         foreach ($modules as $module) {
             // Verifica si el rol tiene permiso para el módulo
             if ($this->hasModulePermission($roleId, $module->id)) {
                 // Obtiene los menús del módulo
                 $menus = Menu::where('module_id', $module->id)->get();
                 $menuPermissions = [];

                 foreach ($menus as $menu) {
                     // Verifica si el rol tiene permiso para el menú
                     if ($this->hasMenuPermission($roleId, $menu->id)) {
                         // Obtiene las acciones del menú
                         $actions = Action::where('menu_id', $menu->id)->get();
                         $actionPermissions = [];

                         foreach ($actions as $action) {
                             // Verifica si el rol tiene permiso para la acción
                             if ($this->hasActionPermission($roleId, $action->id)) {
                                 $actionPermissions[] = $action;
                             }
                         }

                         // Si el rol tiene permisos sobre este menú y tiene acciones permitidas
                         if (count($actionPermissions) > 0) {
                             $menuPermissions[] = [
                                 'menu' => $menu,
                                 'actions' => $actionPermissions,
                             ];
                         }
                     }
                 }

                 // Si el rol tiene permisos sobre menús, agregar el módulo
                 if (count($menuPermissions) > 0) {
                     $modulePermissions[] = [
                         'module' => $module,
                         'menus' => $menuPermissions,
                     ];
                 }
             }
         }

         return response()->json($modulePermissions);
    }
}
