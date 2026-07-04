<?php

namespace App\Filament\Resources\WorkoutLogs\Pages;

use App\Filament\Resources\WorkoutLogs\WorkoutLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkoutLogs extends ListRecords
{
    protected static string $resource = WorkoutLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
