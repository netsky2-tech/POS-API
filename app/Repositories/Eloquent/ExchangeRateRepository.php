<?php

namespace App\Repositories\Eloquent;

use App\Models\Currency;
use App\Repositories\Interfaces\BaseRepositoryInterface;

class ExchangeRateRepository extends BaseRepository implements BaseRepositoryInterface
{
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }

    public function getAll($perPage = 15, $filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = $this->model->query();

        if(isset($filters['search'])){
            $query->where('exchange_rate', 'like', '%' . $filters['search'] . '%')
                ->orWhere('valid_from', 'like', '%' . $filters['search'] . '%');
        }

        if(isset($filters['base_currency_id'])){
            $query->where('base_currency_id', $filters['base_currency_id']);
        }
        if(isset($filters['target_currency_id'])){
            $query->where('target_currency_id', $filters['target_currency_id']);
        }
        return $query->paginate($query);
    }
}
