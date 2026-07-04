<?php

namespace App\Services\Assessment;

use App\Models\Assessment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class IndexAssessmentService
{
    public function run(User $user): Collection
    {
        return Assessment::query()
            ->whereHas('student', fn ($q) => $q->where('user_id', $user->id))
            ->withCount('items')
            ->orderByDesc('created_at')
            ->get();
    }
}
