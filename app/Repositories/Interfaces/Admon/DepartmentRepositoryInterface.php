<?php

namespace App\Repositories\Interfaces\Admon;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface DepartmentRepositoryInterface
{
    public function getAllPaginated($perPage = 15): LengthAwarePaginator;

    public function findDepartmentById($id);

    public function createDepartment(array $data);

    public function updateDepartment($department, array $data);

    public function deleteDepartment($department);
}
