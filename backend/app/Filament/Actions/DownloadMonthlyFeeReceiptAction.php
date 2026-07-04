<?php

namespace App\Filament\Actions;

use App\Models\MonthlyFee;
use App\Services\Pdf\GenerateMonthlyFeeReceiptService;
use Filament\Actions\Action;

class DownloadMonthlyFeeReceiptAction
{
    public static function make(): Action
    {
        return Action::make('downloadPdf')
            ->label('Recibo')
            ->icon('heroicon-o-document-arrow-down')
            ->color('danger')
            ->action(function (MonthlyFee $record) {
                $service = app(GenerateMonthlyFeeReceiptService::class);
                $path = $service->run($record);

                return response()->download($path, "mensalidade-{$record->uuid}.pdf")->deleteFileAfterSend();
            });
    }
}
