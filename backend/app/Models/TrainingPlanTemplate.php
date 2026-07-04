<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Cast;

class TrainingPlanTemplate extends BaseModel
{
    protected $table = 'training_plan_templates';

    protected $fillable = [
        'name',
        'description',
        'goal',
        'experience_level',
        'sessions_per_week',
        'template_data',
        'is_active',
    ];

    #[Cast]
    protected function casts(): array
    {
        return [
            'template_data' => 'array',
            'is_active' => 'boolean',
            'sessions_per_week' => 'integer',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeGoal($query, string $goal)
    {
        return $query->where('goal', $goal);
    }

    public function scopeExperienceLevel($query, string $level)
    {
        return $query->where('experience_level', $level);
    }

    public function getSummaryForLLM(): string
    {
        $divisions = collect($this->template_data['divisions'] ?? []);

        $exercisesCount = $divisions->sum(fn($d) => count($d['exercises'] ?? []));
        $divisionNames = $divisions->pluck('training_division_name')->implode(', ');

        return sprintf(
            "ID %d: '%s' — %s | Objetivo: %s | Nível: %s | %d dias/semana | Divisões: %s | %d exercícios",
            $this->id,
            $this->name,
            $this->description,
            $this->goal_label,
            $this->experience_level_label,
            $this->sessions_per_week,
            $divisionNames,
            $exercisesCount
        );
    }

    public function getGoalLabelAttribute(): string
    {
        return match ($this->goal) {
            'emagrecimento' => 'Emagrecimento',
            'hipertrofia' => 'Hipertrofia',
            'forca' => 'Força',
            'condicionamento' => 'Condicionamento Físico',
            'mobilidade' => 'Mobilidade e Flexibilidade',
            'gluteo' => 'Glúteos e Inferiores',
            'full_body' => 'Corpo Inteiro',
            default => $this->goal ?? 'Geral',
        };
    }

    public function getExperienceLevelLabelAttribute(): string
    {
        return match ($this->experience_level) {
            'iniciante' => 'Iniciante',
            'intermediario' => 'Intermediário',
            'avancado' => 'Avançado',
            'todos' => 'Todos os níveis',
            default => $this->experience_level ?? 'Todos',
        };
    }
}
