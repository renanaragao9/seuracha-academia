<?php

namespace App\Filament\Resources\MonthlyFees\Pages;

use App\Filament\Resources\MonthlyFees\MonthlyFeeResource;
use App\Filament\Resources\Students\StudentResource;
use App\Services\Pdf\GenerateMonthlyFeeReceiptService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMonthlyFee extends ViewRecord
{
    protected static string $resource = MonthlyFeeResource::class;

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
                ->label('Recibo')
                ->color('danger')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $generateMonthlyFeeReceiptService = app(GenerateMonthlyFeeReceiptService::class);
                    $path = $generateMonthlyFeeReceiptService->run($this->record);

                    return response()->download($path, "mensalidade-{$this->record->uuid}.pdf")->deleteFileAfterSend();
                }),

            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
