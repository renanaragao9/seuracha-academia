<?php

namespace App\Filament\Resources\TrainingDivisions\Pages;

use App\Filament\Resources\TrainingDivisions\TrainingDivisionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainingDivision extends EditRecord
{
    protected static string $resource = TrainingDivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
