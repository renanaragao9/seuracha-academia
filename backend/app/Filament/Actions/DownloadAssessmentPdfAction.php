<?php

namespace App\Filament\Actions;

use App\Models\Assessment;
use App\Services\Pdf\GenerateAssessmentPdfService;
use Filament\Actions\Action;

class DownloadAssessmentPdfAction
{
    public static function make(): Action
    {
        return Action::make('downloadPdf')
            ->label('Avaliação PDF')
            ->color('danger')
            ->icon('heroicon-o-document-arrow-down')
            ->action(function (Assessment $record) {
                $service = app(GenerateAssessmentPdfService::class);
                $path = $service->run($record->student_id, assessment: $record);

                $slug = str($record->student->name)->slug()->value();

                return response()->download($path, "avaliacoes-{$slug}.pdf")->deleteFileAfterSend();
            });
    }
}
