<?php

namespace App\Repositories\Eloquent;

use App\Models\Admon\Role;
use App\Models\Currency;
use App\Repositories\Interfaces\Admon\RoleRepositoryInterface;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    protected Currency $model;

    public function __construct(Currency $role)
    {
        $this->model = $role;
    }

    public function getAll(array $filters = [], $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($filters['base_currency_id'])) {
            $query->where('base_currency_id', $filters['base_currency_id']);
        }

        if (!empty($filters['target_currency_id'])) {
            $query->where('target_currency_id', $filters['target_currency_id']);
        }

        if (!empty($filters['date_range'])) {
            $query->whereBetween('valid_from', $filters['date_range']);
        }

        $query->orderBy('valid_from', 'desc');

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
