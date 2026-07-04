<?php

namespace App\Http\Resources\Api\V1\MealPlan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealPlanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'is_active' => $this->is_active,
            'meals_count' => $this->when(! $this->relationLoaded('meals'), $this->meals_count ?? 0),
            'meals' => MealPlanMealResource::collection($this->whenLoaded('meals')),
        ];
    }
}
