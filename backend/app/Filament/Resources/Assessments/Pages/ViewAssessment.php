<?php

namespace App\Filament\Resources\Assessments\Pages;

use App\Filament\Resources\Assessments\AssessmentResource;
use App\Filament\Resources\Students\StudentResource;
use App\Models\Assessment;
use App\Services\Pdf\GenerateAssessmentPdfService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAssessment extends ViewRecord
{
    protected static string $resource = AssessmentResource::class;

    public function getTitle(): string
    {
        return 'Visualizar Avaliação Física';
    }

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
                ->label('Avaliação PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->action(function (Assessment $record) {
                    $service = app(GenerateAssessmentPdfService::class);
                    $path = $service->run($record->student_id, assessment: $record);

                    $slug = str($record->student->name)->slug()->value();

                    return response()->download($path, "avaliacoes-{$slug}.pdf")->deleteFileAfterSend();
                }),

            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
