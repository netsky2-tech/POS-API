<?php

namespace App\Repositories\Eloquent\Admon;

use App\Models\Admon\Action;
use App\Models\Admon\Menu;
use App\Models\Admon\Module;
use App\Models\Admon\Permission;
use App\Models\Admon\Role;
use App\Models\User;
use App\Repositories\Interfaces\Admon\ActionRepositoryInterface;
use App\Repositories\Interfaces\Admon\MenuRepositoryInterface;
use App\Repositories\Interfaces\Admon\ModuleRepositoryInterface;
use App\Repositories\Interfaces\Admon\PermissionRepositoryInterface;
use App\Repositories\Interfaces\Admon\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ActionRepository implements ActionRepositoryInterface
{
    protected Action $model;

    public function __construct(Action $model){
        $this->model = $model;
    }

    public function getByMenuId(int $menuId): Collection
    {
        return $this->model->where('menu_id', $menuId)->get();
    }

    public function getByModuleId(int $moduleId): Collection
    {
        return $this->model->whereHas('menu', function ($query) use ($moduleId) {
            $query->where('module_id', $moduleId);
        })->get();
    }
}
