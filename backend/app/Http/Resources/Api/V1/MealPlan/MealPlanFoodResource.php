<?php

namespace App\Http\Resources\Api\V1\MealPlan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealPlanFoodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order' => $this->order,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'observation' => $this->observation,
            'food' => [
                'id' => $this->food?->id,
                'name' => $this->food?->name ?? '-',
                'image_url' => storage_url($this->food?->image_path),
            ],
        ];
    }
}
