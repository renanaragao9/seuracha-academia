<?php

namespace App\Http\Resources\Api\V1\Purchase;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'subtotal' => $this->subtotal,
            'item' => [
                'id' => $this->item?->id,
                'name' => $this->item?->name ?? '-',
            ],
        ];
    }
}
