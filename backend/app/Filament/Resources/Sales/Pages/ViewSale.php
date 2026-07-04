<?php

namespace App\Filament\Resources\Sales\Pages;

use App\Filament\Actions\DownloadSaleReceiptAction;
use App\Filament\Resources\Sales\SaleResource;
use App\Filament\Resources\Students\StudentResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSale extends ViewRecord
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewStudent')
                ->label('Ver Aluno')
                ->icon('heroicon-o-user')
                ->color('gray')
                ->url(fn () => StudentResource::getUrl('view', ['record' => $this->record->student_id]))
                ->visible(fn () => filled($this->record->student_id)),

            DownloadSaleReceiptAction::make(),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
