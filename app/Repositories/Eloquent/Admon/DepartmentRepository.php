<?php

namespace App\Repositories\Eloquent\Admon;

use App\Models\Admon\Department;
use App\Repositories\Interfaces\Admon\DepartmentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    protected $model;

    public function __construct(Department $department)
    {
        $this->model = $department;
    }

    public function getAllPaginated($perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function findDepartmentById($id)
    {
        return $this->model->find($id);
    }

    public function createDepartment(array $data)
    {
        return $this->model->create($data);
    }

    public function updateDepartment($department, array $data)
    {
        $department->update($data);
        return $department;
    }

    public function deleteDepartment($department): void
    {
        $department->delete();
    }
}
