<?php
namespace App\Services\Admon;

use App\Repositories\Interfaces\Admon\MunicipalityRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MunicipalityService
{
    protected $municipalityRepository;

    public function __construct(MunicipalityRepositoryInterface $municipalityRepository)
    {
        $this->municipalityRepository = $municipalityRepository;
    }

    public function create(array $data)
    {
        return $this->municipalityRepository->createMunicipality($data);
    }

    public function update($id, array $data)
    {
        $municipality = $this->municipalityRepository->findMunicipalityById($id);
        if (!$municipality) {
            throw new ModelNotFoundException('Municipality not found');
        }
        return $this->municipalityRepository->updateMunicipality($municipality, $data);
    }

    public function delete($id)
    {
        $municipality = $this->municipalityRepository->findMunicipalityById($id);
        if (!$municipality) {
            throw new ModelNotFoundException('Municipality not found');
        }
        return $this->municipalityRepository->deleteMunicipality($municipality);
    }
}
