<?php

namespace App\Services\Purchase;

use App\Models\Sale;
use App\Models\User;

class ShowPurchaseService
{
    public function run(Sale $purchase, User $user): Sale
    {
        if ($purchase->student->user_id !== $user->id) {
            abort(404, 'Compra não encontrada.');
        }

        return $purchase->load(['saleItems.item']);
    }
}
