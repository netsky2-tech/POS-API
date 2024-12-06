<?php
namespace App\Services;

use App\Models\Admon\Role;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use App\Repositories\Interfaces\ExchangeRateRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ExchangeRateService
{
    protected ExchangeRateRepositoryInterface $exchangeRateRepository;

    public function __construct(ExchangeRateRepositoryInterface $exchangeRateRepository)
    {
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    public function getAllPaginated($filters = [], $perPage = 15): LengthAwarePaginator
    {
        return $this->exchangeRateRepository->getAll($filters, $perPage);
    }

    public function createExchangeRate(array $data)
    {
        return $this->exchangeRateRepository->store($data);
    }

    public function updateExchangeRate(int $id, array $data)
    {
        return $this->exchangeRateRepository->update($id, $data);
    }

    public function deleteExchangeRate(int $id)
    {
        return $this->exchangeRateRepository->delete($id);
    }
}
