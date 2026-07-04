<?php

namespace App\Http\Resources\Api\V1\TrainingSheet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainingExerciseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order' => $this->order,
            'series' => $this->series,
            'repetitions' => $this->repetitions,
            'rest_seconds' => $this->rest_seconds,
            'load' => $this->load,
            'observation' => $this->observation,
            'exercise' => [
                'id' => $this->exercise?->id,
                'name' => $this->exercise?->name ?? '-',
                'image_url' => storage_url($this->exercise?->image_path),
                'gif_url' => storage_url($this->exercise?->gif_path),
                'video_url' => $this->exercise?->video_path,
            ],
        ];
    }
}
