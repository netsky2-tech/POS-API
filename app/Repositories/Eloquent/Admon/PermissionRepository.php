<?php

namespace App\Repositories\Eloquent\Admon;

use App\Models\Admon\Permission;
use App\Models\Admon\Role;
use App\Models\User;
use App\Repositories\Interfaces\Admon\PermissionRepositoryInterface;
use App\Repositories\Interfaces\Admon\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class PermissionRepository implements PermissionRepositoryInterface
{
    protected Permission $model;

    public function __construct(Permission $model){
        $this->model = $model;
    }

    public function existsForRoleAndAction(int $roleId, int $actionId): bool
    {
        return $this->model->where('action_id', $actionId)
            ->where('role_id', $roleId)
            ->exists();
    }

    public function existsForRoleAndActions(int $roleId, array $actionIds): bool
    {
        return $this->model->whereIn('action_id', $actionIds)
            ->where('role_id', $roleId)
            ->exists();
    }
}
