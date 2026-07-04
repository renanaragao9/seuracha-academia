<?php

namespace App\Services\MonthlyFee;

use App\Models\MonthlyFee;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class IndexMonthlyFeeService
{
    public function run(User $user): Collection
    {
        return MonthlyFee::query()
            ->whereHas('student', fn ($q) => $q->where('user_id', $user->id))
            ->with('planType')
            ->orderByDesc('start_date')
            ->get();
    }
}
