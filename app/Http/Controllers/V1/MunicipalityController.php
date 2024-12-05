<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\Admon\MunicipalityRequest;
use App\Http\Resources\Admon\MunicipalityResource;
use App\Services\Admon\MunicipalityService;


class MunicipalityController extends Controller
{
    protected $municipalityService;

    public function __construct(MunicipalityService $municipalityService)
    {
        $this->municipalityService = $municipalityService;
    }

    public function store(MunicipalityRequest $request)
    {
        $validated = $request->validated();
        $municipality = $this->municipalityService->create($validated);
        return new MunicipalityResource($municipality);
    }

    public function update($id, MunicipalityRequest $request)
    {
        $validated = $request->validated();
        $municipality = $this->municipalityService->update($id, $validated);
        return new MunicipalityResource($municipality);
    }

    public function destroy($id)
    {
        $this->municipalityService->delete($id);
        return response()->noContent();
    }
}
