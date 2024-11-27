<?php


namespace App\Repositories\Interfaces\Admon;

use App\Models\Admon\Permission;
use App\Models\Admon\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

interface ActionRepositoryInterface
{
    public function getByMenuId(int $menuId): Collection;
    public function getByModuleId(int $moduleId): Collection;
}
