<?php

namespace App\Repositories\Interfaces\Admon;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MunicipalityRepositoryInterface
{
    public function getAllByDepartment($departmentId, $perPage = 15): LengthAwarePaginator;

    public function findMunicipalityById($id);

    public function createMunicipality(array $data);

    public function updateMunicipality($municipality, array $data);

    public function deleteMunicipality($municipality);
}
