<?php

namespace App\Filament\Resources\PlanTypes\Pages;

use App\Filament\Resources\PlanTypes\PlanTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPlanType extends EditRecord
{
    protected static string $resource = PlanTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
