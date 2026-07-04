<?php

namespace App\Http\Resources\Api\V1\TrainingSheet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainingSheetDivisionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order' => $this->order,
            'division' => [
                'id' => $this->trainingDivision?->id,
                'name' => $this->trainingDivision?->name ?? '-',
            ],
            'exercises' => $this->whenLoaded('exercises', fn () => TrainingExerciseResource::collection($this->exercises)
            ),
        ];
    }
}
