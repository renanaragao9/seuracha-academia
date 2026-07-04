<?php

namespace App\Filament\Resources\TrainingSheets\Pages;

use App\Filament\Resources\TrainingSheets\TrainingSheetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingSheets extends ListRecords
{
    protected static string $resource = TrainingSheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
