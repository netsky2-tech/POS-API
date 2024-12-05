<?php

namespace App\Http\Resources\Admon;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_menu' => $this->id,
            'title' => $this->name,
            'path' => $this->path,
            'icon' => $this->icon
        ];
    }
}
