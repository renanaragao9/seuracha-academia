<?php

namespace App\Http\Resources\Api\V1\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'code' => $this->code,
            'birth_date' => $this->birth_date?->format('Y-m-d'),
            'entry_date' => $this->entry_date?->format('Y-m-d'),
            'gender' => $this->gender,
            'color' => $this->color,
            'status' => $this->status,
            'image_url' => storage_url($this->image_path),
            'is_active' => $this->is_active,
            'last_access_at' => $this->last_access_at?->format('Y-m-d H:i:s'),
            'weight' => $this->weight,
            'height' => $this->height,
            'notes' => $this->notes,
        ];
    }
}
