<?php

namespace App\Http\Controllers\Admon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    /**
     * permissions: permiso sobre acciones
     * @author octaviom
     */

    public function hasActionPermission($roleId, $actionId)
    {
        $permissions = Permission::where('action_id', $actionId)
            ->where('role_id', $roleId)
            ->exists();

        return $permissions;
    }
}
