<?php

namespace App\Filament\Resources\WorkoutLogs\Pages;

use App\Filament\Resources\WorkoutLogs\WorkoutLogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkoutLog extends EditRecord
{
    protected static string $resource = WorkoutLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
