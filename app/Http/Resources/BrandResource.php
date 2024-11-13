<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'logo' => asset('storage/' . $this->logo),
            'models' => $this->whenLoaded('models', function () {
                return BrandModelResource::collection($this->models);
            }), // Include `brandmodels` only if loaded
        ];
    }
}
