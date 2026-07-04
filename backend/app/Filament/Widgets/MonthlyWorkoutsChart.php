<?php

namespace App\Filament\Widgets;

use App\Models\WorkoutLog;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class MonthlyWorkoutsChart extends ChartWidget
{
    protected static ?int $sort = 5;

    public function getHeading(): string
    {
        return 'Treinos por Mês';
    }

    public function getDescription(): ?string
    {
        return 'Últimos 12 meses';
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $months = [];
        $workoutData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M/Y');

            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            $workoutData[] = WorkoutLog::query()
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Treinos',
                    'data' => $workoutData,
                    'backgroundColor' => '#f97316',
                    'borderColor' => '#ea580c',
                    'borderWidth' => 2,
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
}
