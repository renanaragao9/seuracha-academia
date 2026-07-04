<?php

namespace App\Http\Resources\Api\V1\TrainingSheet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainingSheetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'is_active' => $this->is_active,
            'divisions_count' => $this->whenCounted('divisions'),
            'divisions' => TrainingSheetDivisionResource::collection($this->whenLoaded('divisions')),
            'workout_logs' => WorkoutLogResource::collection($this->whenLoaded('workoutLogs')),
        ];
    }
}
