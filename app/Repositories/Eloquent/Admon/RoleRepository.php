<?php

namespace App\Repositories\Eloquent\Admon;

use App\Models\Admon\Role;
use App\Models\User;
use App\Repositories\Interfaces\Admon\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleRepository implements RoleRepositoryInterface
{
    protected Role $model;

    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function getAllPaginated(array $filters = [], $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query();

        if(isset($filters['search'])){
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }
        return $query->paginate($perPage);
    }

    public function findRoleById($id): ?Role
    {
        return $this->model->find($id);
    }

    public function createRole(array $data): Role
    {
        return $this->model->create($data);
    }

    public function updateRole(Role $role, array $data): Role
    {
        $role->update($data);
        return $role;
    }

    public function deleteRole(Role $role): void
    {
        $role->delete();
    }
}
