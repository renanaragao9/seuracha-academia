<?php

namespace App\Http\Resources\Api\V1\Purchase;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => $this->status,
            'observation' => $this->observation,
            'date_sale' => $this->date_sale?->format('Y-m-d H:i:s'),
            'amount_price' => $this->amount_price,
            'discount_amount' => $this->discount_amount,
            'total_amount' => $this->total_amount,
            'items_count' => $this->when(! $this->relationLoaded('saleItems'), $this->sale_items_count ?? 0),
            'items' => PurchaseItemResource::collection($this->whenLoaded('saleItems')),
        ];
    }
}
