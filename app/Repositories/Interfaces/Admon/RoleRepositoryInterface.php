<?php

namespace App\Repositories\Interfaces\Admon;

use App\Models\Admon\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface
{
    public function getAllRoles(): Collection;
    public function findRoleById($id): ?Role;
    public function createRole(array $data): Role;
    public function updateRole(Role $role, array $data): Role;
    public function deleteRole(Role $role): void;
}
