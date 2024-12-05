<?php


namespace App\Repositories\Interfaces\Admon;

use App\Models\Admon\Menu;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

interface MenuRepositoryInterface
{
    public function getByModuleId(int $moduleId): Collection;

    public function getAll(): Collection;
}
