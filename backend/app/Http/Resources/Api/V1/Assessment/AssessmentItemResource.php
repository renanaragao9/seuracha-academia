<?php

namespace App\Http\Resources\Api\V1\Assessment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'unit' => $this->unit,
            'notes' => $this->notes,
            'measurement_type' => [
                'id' => $this->measurementType?->id,
                'name' => $this->measurementType?->name ?? '-',
            ],
        ];
    }
}
