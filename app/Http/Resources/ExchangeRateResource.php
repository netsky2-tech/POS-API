<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExchangeRateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'base_currency_id' => $this->base_currency_id,
            'target_currency_id' => $this->target_currency_id,
            'exchange_rate' => $this->exchange_rate,
            'valid_from' => $this->valid_from,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
