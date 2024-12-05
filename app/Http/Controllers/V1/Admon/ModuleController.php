<?php

namespace App\Http\Controllers\V1\Admon;

use App\Http\Controllers\V1\Controller;
use App\Models\Admon\Action;
use App\Models\Admon\Permission;

class ModuleController extends Controller
{
    /**
     * actions: acciones dentro de cada modulo
     * permissions: permisos sobre las acciones segun rol
     * @author: octaviom
     */
    public function hasModulePermission($roleId, $moduleId)
    {

        $actions = Action::whereHas('menu', function($query) use ($moduleId) {
            $query->where('module_id', $moduleId);
        })->pluck('id');

        $permissions = Permission::whereIn('action_id', $actions)
        ->where('role_id', $roleId)
        ->exists();

        return $permissions;
    }
}
