<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\MonthlyFee;
use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;

class FinancialStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        $salesCount = Sale::query()->count();
        $salesTotal = (float) Sale::query()->sum('total_amount');
        $salesMonthTotal = (float) Sale::query()->where('date_sale', '>=', $startOfMonth)->sum('total_amount');

        $monthlyFeesTotal = (float) MonthlyFee::query()->sum('amount_paid');
        $monthlyFeesMonthTotal = (float) MonthlyFee::query()->where('date_payment', '>=', $startOfMonth)->sum('amount_paid');

        $expensesTotal = (float) Expense::query()->where('type', 'expense')->sum('total_amount');
        $expensesMonthTotal = (float) Expense::query()
            ->where('type', 'expense')
            ->where('date_maturity', '>=', $startOfMonth)
            ->sum('total_amount');

        $expensesIncomeTotal = (float) Expense::query()->where('type', 'income')->sum('total_amount');
        $expensesIncomeMonthTotal = (float) Expense::query()
            ->where('type', 'income')
            ->where('date_maturity', '>=', $startOfMonth)
            ->sum('total_amount');

        $monthRevenue = $salesMonthTotal + $monthlyFeesMonthTotal + $expensesIncomeMonthTotal;
        $monthBalance = $monthRevenue - $expensesMonthTotal;

        return [
            Stat::make('Compras', Number::format($salesCount, locale: 'pt_BR'))
                ->description('Total de compras registradas')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),

            Stat::make('Faturamento Total', Number::currency($salesTotal + $expensesIncomeTotal, 'BRL', 'pt_BR'))
                ->description('Compras + mensalidades + entradas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Despesas Totais', Number::currency($expensesTotal, 'BRL', 'pt_BR'))
                ->description('Apenas saídas')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Receita do Mês', Number::currency($monthRevenue, 'BRL', 'pt_BR'))
                ->description('Compras + mensalidades + entradas no mês')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Despesas do Mês', Number::currency($expensesMonthTotal, 'BRL', 'pt_BR'))
                ->description('Apenas saídas com vencimento no mês')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('danger'),

            Stat::make('Saldo do Mês', Number::currency($monthBalance, 'BRL', 'pt_BR'))
                ->description('Receita - despesas do mês atual')
                ->descriptionIcon('heroicon-m-scale')
                ->color($monthBalance >= 0 ? 'success' : 'danger'),
        ];
    }
}
