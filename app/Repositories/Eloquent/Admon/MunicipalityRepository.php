<?php

namespace App\Repositories\Eloquent\Admon;


use App\Models\Admon\Municipality;
use App\Repositories\Interfaces\Admon\MunicipalityRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MunicipalityRepository implements MunicipalityRepositoryInterface
{
    protected $model;

    public function __construct(Municipality $municipality)
    {
        $this->model = $municipality;
    }

    public function getAllByDepartment($departmentId, $perPage = 15): LengthAwarePaginator
    {
        return $this->model->where('department_id', $departmentId)->paginate($perPage);
    }

    public function findMunicipalityById($id)
    {
        return $this->model->find($id);
    }

    public function createMunicipality(array $data)
    {
        return $this->model->create($data);
    }

    public function updateMunicipality($municipality, array $data)
    {
        $municipality->update($data);
        return $municipality;
    }

    public function deleteMunicipality($municipality): void
    {
        $municipality->delete();
    }
}
