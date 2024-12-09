<?php

namespace App\Repositories\Eloquent;

use App\Models\Currency;
use App\Repositories\Interfaces\BaseRepositoryInterface;

class CurrencyRepository extends BaseRepository implements BaseRepositoryInterface
{
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }

    public function getAll($perPage = 15, $filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = $this->model->query();

        if(isset($filters['search'])){
            $query->where('code', 'like', '%' . $filters['search'] . '%')
                ->orWhere('name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('symbol', 'like', '%' . $filters['search'] . '%');
        }
        return $query->paginate($query);
    }
}
