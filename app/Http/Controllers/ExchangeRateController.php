<?php

namespace App\Http\Controllers;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\ExchangeRateRequest;
use App\Http\Resources\ExchangeRateResource;
use App\Models\ExchangeRate;
use App\Services\ExchangeRateService;
use Illuminate\Support\Facades\Request;

class ExchangeRateController extends Controller
{
    protected ExchangeRateService $service;

    public function __construct(ExchangeRateService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {

        $filters = [
            'search' => $request->only('search'),
            'base_currency_id' => $request->only('base_currency_id'),
            'target_currency_id' => $request->only('target_currency_id'),
            'valid_from' => $request->only('valid_from'),
            'exchange_rate' => $request->only('exchange_rate')
        ];

        $perPage = $request->query('per_page', 15);

        $rates = $this->service->getAllPaginated($perPage, $filters);

        return response()->json($rates);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ExchangeRateRequest $request): ExchangeRateResource
    {
        $data = $request->validated();

        $currency = $this->service->createExchangeRate($data);

        return new ExchangeRateResource($currency);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ExchangeRateRequest $request, $data): ExchangeRateResource|\Illuminate\Http\JsonResponse
    {
        $currency = $this->service->updateExchangeRate($request->validated(), $data);
        if($currency){
            return new ExchangeRateResource($currency);
        }
        return response()->json(['message' => 'No se encuentra la tasa de cambio seleccionada.'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($this->service->deleteExchangeRate($id)){
            return response()->json(['message' => 'Tasa de cambio desactivada correctamente'],200);
        }
        return response()->json(['message' => 'Tasa de cambio no encontrada.'], 404);
    }
}
