<?php

namespace App\Filament\Resources\TrainingSheets\Pages;

use App\Filament\Resources\Students\StudentResource;
use App\Filament\Resources\TrainingSheets\TrainingSheetResource;
use App\Services\Pdf\GenerateTrainingSheetPdfService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTrainingSheet extends ViewRecord
{
    protected static string $resource = TrainingSheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewStudent')
                ->label('Ver Aluno')
                ->icon('heroicon-o-user')
                ->color('gray')
                ->url(fn () => StudentResource::getUrl('view', [
                    'record' => $this->record->student,
                ])),
            Action::make('downloadPdf')
                ->label('Ficha PDF')
                ->color('danger')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $generateTrainingSheetPdfService = app(GenerateTrainingSheetPdfService::class);
                    $path = $generateTrainingSheetPdfService->run($this->record);

                    return response()->download($path, "ficha-{$this->record->id}.pdf")->deleteFileAfterSend();
                }),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
