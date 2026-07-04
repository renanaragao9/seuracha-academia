<?php

namespace App\Services\ItemType;

use App\Models\ItemType;
use Illuminate\Database\Eloquent\Collection;

class IndexItemTypeService
{
    public function run(): Collection
    {
        return ItemType::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }
}
