<?php


namespace App\Repositories\Interfaces\Admon;

use App\Models\Admon\Permission;
use App\Models\Admon\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

interface ModuleRepositoryInterface
{
    public function getAll(): Collection;
}
