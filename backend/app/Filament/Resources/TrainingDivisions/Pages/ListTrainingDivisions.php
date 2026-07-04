<?php

namespace App\Filament\Resources\TrainingDivisions\Pages;

use App\Filament\Resources\TrainingDivisions\TrainingDivisionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingDivisions extends ListRecords
{
    protected static string $resource = TrainingDivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
