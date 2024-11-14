<?php
namespace App\Services\Admon;

use App\Models\Admon\Role;
use App\Repositories\Interfaces\Admon\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RoleService
{
    protected RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles(): Collection
    {
        return $this->roleRepository->getAllRoles();
    }

    public function getRoleById(int $id): ?Role
    {
        return $this->roleRepository->findRoleById($id) ?? null;
    }

    public function createRole(array $data): Role
    {
        return $this->roleRepository->createRole($data);
    }

    public function updateRole(int $id, array $data): ?Role
    {
        $role = $this->roleRepository->findRoleById($id);

        if ($role) {
            return $this->roleRepository->updateRole($role, $data);
        }

        return null;
    }

    public function deleteRole(int $id): ?bool
    {
        $role = $this->roleRepository->findRoleById($id);

        if ($role) {
            $this->roleRepository->deleteRole($role);
            return true;
        }

        return false;
    }
}
