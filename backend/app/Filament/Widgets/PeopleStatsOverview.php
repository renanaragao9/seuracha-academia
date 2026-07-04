<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class PeopleStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $usersCount = User::query()->count();
        $studentsCount = Student::query()->count();
        $activeStudentsCount = Student::query()->where('is_active', true)->count();

        return [
            Stat::make('Usuários', Number::format($usersCount, locale: 'pt_BR'))
                ->description('Total de usuários cadastrados')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Alunos', Number::format($studentsCount, locale: 'pt_BR'))
                ->description('Total de alunos cadastrados')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Alunos Ativos', Number::format($activeStudentsCount, locale: 'pt_BR'))
                ->description('Com status ativo no sistema')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
