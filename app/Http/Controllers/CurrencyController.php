<?php

namespace App\Http\Controllers;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Http\Resources\CurrencyResource;
use App\Services\CurrencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Currency",
 *     type="object",
 *     title="Currency",
 *     required={"code", "name", "symbol"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID de la moneda"
 *     ),
 *     @OA\Property(
 *         property="code",
 *         type="string",
 *         description="Codigo de la moneda"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre de la moneda"
 *     ),
 *     @OA\Property(
 *         property="symbol",
 *         type="string",
 *         description="Simbolo de la moneda"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de creación"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de actualización"
 *     )
 * )
 */


class CurrencyController extends Controller
{
    protected CurrencyService $service;

    public function __construct(CurrencyService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $filters = $request->only('search');
        $perPage = $request->query('per_page', 15);
        $currencies = $this->service->getAllPaginated($filters, $perPage);

        return response()->json($currencies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurrencyRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        $currency = $this->service->createCurency($data);

        return response()->json($currency, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $currency = $this->service->getCurrencyById($id);

        return response()->json($currency);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CurrencyRequest $request, $data): JsonResponse|CurrencyResource
    {
        $currency = $this->service->updateCurrency($request->validated(), $data);
        if($currency){
            return new CurrencyResource($currency);
        }
        return response()->json(['message' => 'No se encuentra la moneda seleccionada.'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        if($this->service->deleteCurrency($id)){
            return response()->json(['message' => 'Moneda desactivada correctamente'],200);
        }
        return response()->json(['message' => 'Moneda no encontrada.'], 404);
    }
}
