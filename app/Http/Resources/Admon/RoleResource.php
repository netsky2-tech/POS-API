<?php

namespace App\Http\Resources\Admon;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleResource extends JsonResource
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
            'name' => $this->name,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

    public static function collection($resource): \Illuminate\Http\Resources\Json\AnonymousResourceCollection|array
    {
        if ($resource instanceof LengthAwarePaginator) {
            return [
                'data' => parent::collection($resource->items()),
                'meta' => [
                    'current_page' => $resource->currentPage(),
                    'per_page' => $resource->perPage(),
                    'total' => $resource->total(),
                    'total_pages' => $resource->lastPage(),
                ],
                'links' => [
                    'first' => $resource->url(1),
                    'last' => $resource->url($resource->lastPage()),
                    'prev' => $resource->previousPageUrl(),
                    'next' => $resource->nextPageUrl(),
                ]
            ];
        }

        return parent::collection($resource);
    }
}
