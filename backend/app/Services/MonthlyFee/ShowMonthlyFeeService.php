<?php

namespace App\Services\MonthlyFee;

use App\Models\MonthlyFee;
use App\Models\User;

class ShowMonthlyFeeService
{
    public function run(MonthlyFee $monthlyFee, User $user): MonthlyFee
    {
        if ($monthlyFee->student->user_id !== $user->id) {
            abort(404, 'Mensalidade não encontrada.');
        }

        return $monthlyFee->load(['planType', 'paymentType']);
    }
}
