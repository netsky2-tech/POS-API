<?php

namespace App\Repositories\Eloquent\Admon;

use App\Models\Admon\Menu;
use App\Models\Admon\Module;
use App\Models\Admon\Permission;
use App\Models\Admon\Role;
use App\Models\User;
use App\Repositories\Interfaces\Admon\MenuRepositoryInterface;
use App\Repositories\Interfaces\Admon\ModuleRepositoryInterface;
use App\Repositories\Interfaces\Admon\PermissionRepositoryInterface;
use App\Repositories\Interfaces\Admon\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class MenuRepository implements MenuRepositoryInterface
{
    protected Menu $model;

    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

    /**
     * Obtener todos los menús.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function getByModuleId(int $moduleId): Collection
    {
        return $this->model->where('module_id', $moduleId)->get();
    }
}
