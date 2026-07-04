<?php

namespace App\Services\Landing;

use App\Http\Resources\Api\V1\Configuration\ConfigurationResource;
use App\Models\Configuration;
use App\Models\PlanType;
use App\Models\Student;
use App\Models\User;

class ShowLandingService
{
    public function run(): array
    {
        $configuration = Configuration::first();

        if (! $configuration) {
            abort(404, 'Configuração não encontrada.');
        }

        $activeStudents = Student::where('is_active', true)->count();

        $yearsExperience = $configuration->created_at
            ? max(1, $configuration->created_at->diffInYears(now()))
            : 1;

        $professorsCount = User::whereHas('role', function ($q) {
            $q->where('name', '!=', 'Estudante');
        })->count();

        $plans = PlanType::where('is_active', true)->get()->map(function ($plan) {
            return [
                'id' => $plan->id,
                'name' => $plan->name,
                'description' => $plan->description,
                'amount_base' => $plan->amount_base,
                'period_days' => $plan->period_days,
            ];
        });

        return [
            'configuration' => new ConfigurationResource($configuration),
            'stats' => [
                'active_students' => $activeStudents,
                'years_experience' => $yearsExperience,
                'professors_count' => $professorsCount,
            ],
            'plans' => $plans,
        ];
    }
}
