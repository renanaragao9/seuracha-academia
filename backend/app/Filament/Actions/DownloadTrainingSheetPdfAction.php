<?php

namespace App\Filament\Actions;

use App\Models\TrainingSheet;
use App\Services\Pdf\GenerateTrainingSheetPdfService;
use Filament\Actions\Action;

class DownloadTrainingSheetPdfAction
{
    public static function make(): Action
    {
        return Action::make('downloadPdf')
            ->label('Ficha PDF')
            ->color('danger')
            ->icon('heroicon-o-document-arrow-down')
            ->action(function (TrainingSheet $record) {
                $service = app(GenerateTrainingSheetPdfService::class);
                $path = $service->run($record);

                return response()->download($path, "ficha-{$record->id}.pdf")->deleteFileAfterSend();
            });
    }
}
