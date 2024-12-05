<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\Admon\DepartmentRequest;
use App\Http\Resources\Admon\DepartmentResource;
use App\Services\Admon\DepartmentService;


class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function store(DepartmentRequest $request)
    {
        $validated = $request->validated();
        $department = $this->departmentService->create($validated);
        return new DepartmentResource($department);
    }

    public function update($id, DepartmentRequest $request)
    {
        $validated = $request->validated();
        $department = $this->departmentService->update($id, $validated);
        return new DepartmentResource($department);
    }

    public function destroy($id): \Illuminate\Http\Response
    {
        $this->departmentService->delete($id);
        return response()->noContent();
    }
}
