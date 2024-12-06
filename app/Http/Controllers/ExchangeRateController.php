<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use App\Http\Requests\StoreExchangeRateRequest;
use App\Http\Requests\UpdateExchangeRateRequest;
use Illuminate\Support\Facades\Request;

class ExchangeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'base_currency_id' => 'nullable|exists:currencies,id',
            'target_currency_id' => 'nullable|exists:currencies,id',
            'per_page' => 'nullable|integer|min:1|max:100',
            'date_range' => 'nullable|string',
        ]);

        $filters = [
            'base_currency_id' => $request->query('base_currency_id'),
            'target_currency_id' => $request->query('target_currency_id'),
            'date_range' => $request->query('date_range') ? explode(',', $request->query('date_range')) : null
        ];

        $perPage = $request->query('per_page', 15);

        $rates = $this->service->getAll($perPage, $filters);

        return response()->json($rates);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExchangeRateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ExchangeRate $exchangeRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExchangeRate $exchangeRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExchangeRateRequest $request, ExchangeRate $exchangeRate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExchangeRate $exchangeRate)
    {
        //
    }
}
