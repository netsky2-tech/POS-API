<?php


namespace App\Repositories\Interfaces\Admon;

use App\Models\Admon\Permission;
use App\Models\Admon\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

interface PermissionRepositoryInterface
{
    public function existsForRoleAndAction(int $roleId, int $actionId): bool;
    public function existsForRoleAndActions(int $roleId, array $actionIds): bool;
}
