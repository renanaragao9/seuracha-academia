<?php

namespace App\Filament\Resources\MealPlans\Pages;

use App\Filament\Resources\MealPlans\MealPlanResource;
use App\Filament\Resources\Students\StudentResource;
use App\Services\Pdf\GenerateMealPlanPdfService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMealPlan extends ViewRecord
{
    protected static string $resource = MealPlanResource::class;

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
                ->label('Plano Alimentar PDF')
                ->color('danger')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $service = app(GenerateMealPlanPdfService::class);
                    $path = $service->run($this->record);

                    return response()->download($path, "plano-alimentar-{$this->record->id}.pdf")->deleteFileAfterSend();
                }),
            EditAction::make(),
        ];
    }
}
