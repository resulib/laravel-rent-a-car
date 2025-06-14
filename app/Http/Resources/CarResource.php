<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
            'brand' => $this->model->brand->name,
            'model' => $this->model->name,
            'slug' => $this->slug,
            'year' => $this->year,
            'description' => $this->description,
            'seats' => $this->seats,
            'transmission' => $this->transmission,
            'fuel_type' => $this->fuel_type,
            'price_per_day' => $this->price_per_day,
            'status' => $this->status,
        ];
    }
}
