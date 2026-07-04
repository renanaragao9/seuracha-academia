<?php

namespace App\Filament\Actions;

use App\Models\Sale;
use App\Services\Pdf\GenerateSaleReceiptPdfService;
use Filament\Actions\Action;

class DownloadSaleReceiptAction
{
    public static function make(): Action
    {
        return Action::make('downloadPdf')
            ->label('Recibo')
            ->icon('heroicon-o-document-arrow-down')
            ->color('danger')
            ->action(function (Sale $record) {
                $service = app(GenerateSaleReceiptPdfService::class);
                $path = $service->run($record);

                return response()->download($path, "recibo-{$record->uuid}.pdf")->deleteFileAfterSend();
            });
    }
}
