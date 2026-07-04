<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\MonthlyFee;
use App\Models\Sale;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueExpensesChart extends ChartWidget
{
    protected static ?int $sort = 4;

    public function getHeading(): string
    {
        return 'Receita vs Despesas';
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
        $revenueData = [];
        $expenseData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabel = $date->format('M/Y');
            $months[] = $monthLabel;

            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            $salesTotal = (float) Sale::query()
                ->whereBetween('date_sale', [$startOfMonth, $endOfMonth])
                ->sum('total_amount');

            $feesTotal = (float) MonthlyFee::query()
                ->whereBetween('date_payment', [$startOfMonth, $endOfMonth])
                ->sum('amount_paid');

            $incomeTotal = (float) Expense::query()
                ->where('type', 'income')
                ->whereBetween('date_maturity', [$startOfMonth, $endOfMonth])
                ->sum('total_amount');

            $revenueData[] = $salesTotal + $feesTotal + $incomeTotal;

            $expenseData[] = (float) Expense::query()
                ->where('type', 'expense')
                ->whereBetween('date_maturity', [$startOfMonth, $endOfMonth])
                ->sum('total_amount');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Receita',
                    'data' => $revenueData,
                    'backgroundColor' => '#22c55e',
                    'borderColor' => '#22c55e',
                ],
                [
                    'label' => 'Despesas',
                    'data' => $expenseData,
                    'backgroundColor' => '#ef4444',
                    'borderColor' => '#ef4444',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getOptions(): array|RawJs|null
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
