<?php

namespace App\Services\Item;

use App\Models\Item;

class ShowItemService
{
    public function run(Item $item): Item
    {
        return $item->load(['itemType', 'itemFieldTypes.fieldType']);
    }
}
