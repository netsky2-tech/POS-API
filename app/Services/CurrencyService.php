<?php
namespace App\Services\Admon;

use App\Models\Admon\Role;
use App\Repositories\Interfaces\Admon\RoleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleService
{
    protected RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllPaginated(array $filters, int $perPage): LengthAwarePaginator
    {
        return $this->roleRepository->getAllPaginated($filters, $perPage);
    }

    public function getRoleById(int $id): ?Role
    {
        return $this->roleRepository->findRoleById($id) ?? null;
    }

    public function createRole(array $data): Role
    {
        return $this->roleRepository->createRole($data);
    }

    public function updateRole(Role $role, array $data): Role
    {
        return $this->roleRepository->updateRole($role, $data);
    }

    public function deleteRole(Role $role): void
    {
        $this->roleRepository->deleteRole($role);
    }
}
