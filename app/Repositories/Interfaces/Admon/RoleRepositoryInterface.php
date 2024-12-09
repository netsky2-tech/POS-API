<?php

namespace App\Repositories\Interfaces\Admon;

use App\Models\Admon\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RoleRepositoryInterface
{
    public function getAllPaginated(array $filters = [], $perPage = 15): LengthAwarePaginator;
    public function findRoleById($id): ?Role;
    public function createRole(array $data): Role;
    public function updateRole(Role $role, array $data): Role;
    public function deleteRole(Role $role): void;
}
