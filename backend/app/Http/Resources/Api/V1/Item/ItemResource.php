<?php

namespace App\Http\Resources\Api\V1\Item;

use App\Http\Resources\Api\V1\ItemType\ItemTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => storage_url($this->image_path),
            'total_price' => $this->total_price,
            'promotion_price' => $this->promotion_price,
            'item_type' => new ItemTypeResource($this->whenLoaded('itemType')),
            'fields' => $this->when($this->relationLoaded('itemFieldTypes'), fn () =>
                $this->itemFieldTypes->map(fn ($ift) => [
                    'id' => $ift->id,
                    'value' => $ift->value,
                    'field_type' => $ift->relationLoaded('fieldType') ? [
                        'id' => $ift->fieldType->id,
                        'name' => $ift->fieldType->name,
                    ] : null,
                ])
            ),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
