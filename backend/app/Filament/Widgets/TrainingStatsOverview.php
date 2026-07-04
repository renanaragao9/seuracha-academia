<?php

namespace App\Filament\Widgets;

use App\Models\Assessment;
use App\Models\Booking;
use App\Models\CustomerRegistration;
use App\Models\TrainingSheet;
use App\Models\WorkoutLog;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class TrainingStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $trainingSheetsCount = TrainingSheet::query()->count();
        $activeTrainingSheetsCount = TrainingSheet::query()->where('is_active', true)->count();
        $assessmentsCount = Assessment::query()->count();
        $workoutLogsCount = WorkoutLog::query()->count();
        $bookingsCount = Booking::query()->count();
        $customerRegistrationsCount = CustomerRegistration::query()->count();

        return [
            Stat::make('Fichas', Number::format($trainingSheetsCount, locale: 'pt_BR'))
                ->description('Total de fichas de treino')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('info'),

            Stat::make('Fichas Ativas', Number::format($activeTrainingSheetsCount, locale: 'pt_BR'))
                ->description('Com status ativo')
                ->descriptionIcon('heroicon-m-bolt')
                ->color('success'),

            Stat::make('Avaliações', Number::format($assessmentsCount, locale: 'pt_BR'))
                ->description('Total de avaliações físicas')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('warning'),

            Stat::make('Treinos', Number::format($workoutLogsCount, locale: 'pt_BR'))
                ->description('Total de treinos realizados')
                ->descriptionIcon('heroicon-m-fire')
                ->color('primary'),

            Stat::make('Eventos', Number::format($bookingsCount, locale: 'pt_BR'))
                ->description('Total de eventos')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('gray'),

            Stat::make('Pré-Registros', Number::format($customerRegistrationsCount, locale: 'pt_BR'))
                ->description('Total de pré-registros de clientes')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('gray'),
        ];
    }
}
