<?php

namespace App\Http\Controllers\V1\Admon;

use App\Http\Controllers\V1\Controller;
use App\Models\Admon\Permission;

class ActionController extends Controller
{
    /**
     * permissions: permiso sobre acciones
     * @author octaviom
     */

    public function hasActionPermission($roleId, $actionId)
    {
        return Permission::where('action_id', $actionId)
            ->where('role_id', $roleId)
            ->exists();
    }
}
