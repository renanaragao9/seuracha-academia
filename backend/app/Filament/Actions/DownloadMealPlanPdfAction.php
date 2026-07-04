<?php

namespace App\Filament\Actions;

use App\Models\MealPlan;
use App\Services\Pdf\GenerateMealPlanPdfService;
use Filament\Actions\Action;

class DownloadMealPlanPdfAction
{
    public static function make(): Action
    {
        return Action::make('downloadPdf')
            ->label('Plano Alimentar PDF')
            ->icon('heroicon-o-document-arrow-down')
            ->color('danger')
            ->action(function (MealPlan $record) {
                $service = app(GenerateMealPlanPdfService::class);
                $path = $service->run($record);

                return response()->download($path, "plano-alimentar-{$record->id}.pdf")->deleteFileAfterSend();
            });
    }
}
