<?php

namespace App\Services\TrainingSheet;

use App\Models\TrainingSheet;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class IndexTrainingSheetService
{
    public function run(User $user): Collection
    {
        return TrainingSheet::query()
            ->whereHas('student', fn ($q) => $q->where('user_id', $user->id))
            ->withCount('divisions')
            ->where('is_active', true)
            ->orderByDesc('start_date')
            ->get();
    }
}
