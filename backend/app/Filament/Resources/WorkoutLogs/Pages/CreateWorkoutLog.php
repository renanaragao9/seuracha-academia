<?php

namespace App\Filament\Resources\WorkoutLogs\Pages;

use App\Filament\Resources\WorkoutLogs\WorkoutLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkoutLog extends CreateRecord
{
    protected static string $resource = WorkoutLogResource::class;
}
