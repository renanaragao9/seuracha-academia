<?php

namespace App\Http\Resources\Api\V1\TrainingSheet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutLogExerciseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'performed_series' => $this->performed_series,
            'performed_repetitions' => $this->performed_repetitions,
            'performed_load' => $this->performed_load,
            'completed' => $this->completed,
            'observation' => $this->observation,
            'exercise' => [
                'id' => $this->exercise?->id,
                'name' => $this->exercise?->name ?? '-',
            ],
        ];
    }
}
