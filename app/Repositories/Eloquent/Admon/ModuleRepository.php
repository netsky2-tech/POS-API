<?php

namespace App\Repositories\Eloquent\Admon;

use App\Models\Admon\Module;
use App\Models\Admon\Permission;
use App\Models\Admon\Role;
use App\Models\User;
use App\Repositories\Interfaces\Admon\ModuleRepositoryInterface;
use App\Repositories\Interfaces\Admon\PermissionRepositoryInterface;
use App\Repositories\Interfaces\Admon\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ModuleRepository implements ModuleRepositoryInterface
{
    protected Module $model;

    public function __construct(Module $model){
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }
}
