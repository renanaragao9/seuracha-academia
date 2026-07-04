<?php

namespace App\Services\Item;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;

class IndexItemService
{
    public function run(array $data): Collection
    {
        $itemTypeId = $data['item_type_id'] ?? null;
        $sort = $data['sort'] ?? null;
        $promotion = $data['promotion'] ?? null;

        $query = Item::query()
            ->with('itemType');

        if ($itemTypeId) {
            $query->where('item_type_id', $itemTypeId);
        }

        if ($promotion) {
            $query->whereNotNull('promotion_price');
        }

        match ($sort) {
            'price_asc' => $query->orderBy('total_price'),
            'price_desc' => $query->orderByDesc('total_price'),
            default => $query->orderByDesc('created_at'),
        };

        return $query->get();
    }
}
