<?php

namespace App\Services\Purchase;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class IndexPurchaseService
{
    public function run(User $user): Collection
    {
        return Sale::query()
            ->whereHas('student', fn ($q) => $q->where('user_id', $user->id))
            ->withCount('saleItems')
            ->orderByDesc('date_sale')
            ->get();
    }
}
