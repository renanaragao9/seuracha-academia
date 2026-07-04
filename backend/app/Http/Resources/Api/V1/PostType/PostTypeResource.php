<?php

namespace App\Http\Resources\Api\V1\PostType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];
    }
}
