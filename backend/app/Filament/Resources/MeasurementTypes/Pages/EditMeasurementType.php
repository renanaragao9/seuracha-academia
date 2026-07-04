<?php

namespace App\Filament\Resources\MeasurementTypes\Pages;

use App\Filament\Resources\MeasurementTypes\MeasurementTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditMeasurementType extends EditRecord
{
    protected static string $resource = MeasurementTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
