<?php

namespace App\Http\Resources\Api\V1\Assessment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'observations' => $this->observations,
            'is_active' => $this->is_active,
            'items' => AssessmentItemResource::collection($this->whenLoaded('items')),
            'items_count' => $this->when(!$this->relationLoaded('items'), $this->items_count ?? 0),
        ];
    }
}
