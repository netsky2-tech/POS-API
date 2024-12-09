<?php
namespace App\Services;

use App\Models\Admon\Role;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CurrencyService
{
    protected CurrencyRepositoryInterface $currencyRepository;

    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function getAllPaginated($filters = [], $perPage = 15): LengthAwarePaginator
    {
        return $this->currencyRepository->getAll($filters, $perPage);
    }

    public function getCurrencyById(int $id)
    {
        return $this->currencyRepository->findById($id) ?? null;
    }

    public function createCurency(array $data)
    {
        return $this->currencyRepository->store($data);
    }

    public function updateCurrency(int $id, array $data)
    {
        return $this->currencyRepository->update($id, $data);
    }

    public function deleteCurrency(int $id)
    {
        return $this->currencyRepository->delete($id);
    }
}
