<?php

namespace App\Observers;

use App\Models\MonthlyFee;
use App\Notifications\MonthlyFee\MonthlyFeeCreated;

class MonthlyFeeObserver
{
    public function created(MonthlyFee $monthlyFee): void
    {
        $student = $monthlyFee->student;

        if ($student?->email) {
            $student->notify(new MonthlyFeeCreated($monthlyFee));
        }
    }
}
