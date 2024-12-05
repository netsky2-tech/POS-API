<?php
namespace App\Services\Admon;

use App\Repositories\Interfaces\Admon\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DepartmentService
{
    protected $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function create(array $data)
    {
        return $this->departmentRepository->createDepartment($data);
    }

    public function update($id, array $data)
    {
        $department = $this->departmentRepository->findDepartmentById($id);
        if (!$department) {
            throw new ModelNotFoundException('Department not found');
        }
        return $this->departmentRepository->updateDepartment($department, $data);
    }

    public function delete($id)
    {
        $department = $this->departmentRepository->findDepartmentById($id);
        if (!$department) {
            throw new ModelNotFoundException('Department not found');
        }
        return $this->departmentRepository->deleteDepartment($department);
    }
}
