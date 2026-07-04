<?php

namespace App\Http\Resources\Api\V1\TrainingSheet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'started_at' => $this->started_at?->format('Y-m-d H:i:s'),
            'finished_at' => $this->finished_at?->format('Y-m-d H:i:s'),
            'duration_minutes' => $this->duration_minutes,
            'division' => [
                'id' => $this->sheetDivision?->id,
                'name' => $this->sheetDivision?->trainingDivision?->name ?? '-',
            ],
            'validator' => [
                'id' => $this->validator?->id,
                'name' => $this->validator?->name,
            ],
            'log_exercises' => $this->whenLoaded('logExercises', fn () =>
                WorkoutLogExerciseResource::collection($this->logExercises)
            ),
        ];
    }
}
