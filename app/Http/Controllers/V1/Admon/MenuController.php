<?php

namespace App\Http\Controllers\V1\Admon;


use App\Http\Controllers\V1\Controller;
use App\Models\Admon\Action;
use App\Models\Admon\Permission;

class MenuController extends Controller
{
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
}
