<?php

namespace App\Filament\Widgets;

use App\Models\Assessment;
use App\Models\Booking;
use App\Models\Expense;
use App\Models\MonthlyFee;
use App\Models\Sale;
use App\Models\Student;
use App\Models\TrainingSheet;
use App\Models\User;
use App\Models\WorkoutLog;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;

class ReportsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        $usersCount = User::query()->count();
        $studentsCount = Student::query()->count();
        $trainingSheetsCount = TrainingSheet::query()->count();
        $activeTrainingSheetsCount = TrainingSheet::query()->where('is_active', true)->count();

        $assessmentsCount = Assessment::query()->count();
        $workoutLogsCount = WorkoutLog::query()->count();
        $bookingsCount = Booking::query()->count();

        $salesCount = Sale::query()->count();
        $salesTotal = Sale::query()->sum('total_amount');
        $salesMonthTotal = Sale::query()->where('date_sale', '>=', $startOfMonth)->sum('total_amount');

        $monthlyFeesTotal = MonthlyFee::query()->sum('amount_paid');
        $monthlyFeesMonthTotal = MonthlyFee::query()->where('date_payment', '>=', $startOfMonth)->sum('amount_paid');

        $expensesTotal = Expense::query()->sum('total_amount');
        $expensesMonthTotal = Expense::query()->where('date_maturity', '>=', $startOfMonth)->sum('total_amount');

        $monthRevenue = $salesMonthTotal + $monthlyFeesMonthTotal;
        $monthBalance = $monthRevenue - $expensesMonthTotal;

        return [
            Stat::make('Usuários', Number::format($usersCount, locale: 'pt_BR'))
                ->description('Total de usuários cadastrados')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Alunos', Number::format($studentsCount, locale: 'pt_BR'))
                ->description('Total de alunos cadastrados')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Fichas', Number::format($trainingSheetsCount, locale: 'pt_BR'))
                ->description('Total de fichas de treino')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('info'),

            Stat::make('Fichas Ativas', Number::format($activeTrainingSheetsCount, locale: 'pt_BR'))
                ->description('Fichas com status ativo')
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

            Stat::make('Compras', Number::format($salesCount, locale: 'pt_BR'))
                ->description('Quantidade de compras registradas')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),

            Stat::make('Compras (Total)', Number::currency($salesTotal, 'BRL', 'pt_BR'))
                ->description('Soma total das compras')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Mensalidades', Number::currency($monthlyFeesTotal, 'BRL', 'pt_BR'))
                ->description('Soma de mensalidades pagas')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            Stat::make('Despesas', Number::currency($expensesTotal, 'BRL', 'pt_BR'))
                ->description('Soma total de despesas')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Receita do Mês', Number::currency($monthRevenue, 'BRL', 'pt_BR'))
                ->description('Compras + mensalidades no mês atual')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Despesas do Mês', Number::currency($expensesMonthTotal, 'BRL', 'pt_BR'))
                ->description('Despesas vencendo no mês atual')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('danger'),

            Stat::make('Saldo do Mês', Number::currency($monthBalance, 'BRL', 'pt_BR'))
                ->description('Receita do mês menos despesas do mês')
                ->descriptionIcon('heroicon-m-scale')
                ->color($monthBalance >= 0 ? 'success' : 'danger'),
        ];
    }
}
