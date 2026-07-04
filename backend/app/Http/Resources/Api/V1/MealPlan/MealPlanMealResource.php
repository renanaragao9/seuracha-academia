<?php

namespace App\Http\Resources\Api\V1\MealPlan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealPlanMealResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order' => $this->order,
            'meal_type' => [
                'id' => $this->mealType?->id,
                'name' => $this->mealType?->name ?? '-',
            ],
            'foods' => MealPlanFoodResource::collection($this->foods),
        ];
    }
}
