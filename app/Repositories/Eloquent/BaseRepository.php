<?php

namespace App\Repositories\Eloquent;

use App\Models\Currency;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll($perPage = 15, $filters = [])
    {
        $query = $this->model->query();

        return $query->paginate($perPage);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $record = $this->findById($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id)
    {
        $record = $this->findById($id);
        if(!$record){
            return false;
        }
        $record->status = 0;
        return $record->save();
    }
}
