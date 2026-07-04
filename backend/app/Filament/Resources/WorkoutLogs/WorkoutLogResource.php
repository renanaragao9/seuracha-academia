<?php

namespace App\Filament\Resources\WorkoutLogs;

use App\Filament\BaseResource;
use App\Filament\Resources\WorkoutLogs\Pages\CreateWorkoutLog;
use App\Filament\Resources\WorkoutLogs\Pages\EditWorkoutLog;
use App\Filament\Resources\WorkoutLogs\Pages\ListWorkoutLogs;
use App\Filament\Resources\WorkoutLogs\Pages\ViewWorkoutLog;
use App\Filament\Resources\WorkoutLogs\RelationManagers\LogExercisesRelationManager;
use App\Filament\Resources\WorkoutLogs\Schemas\WorkoutLogForm;
use App\Filament\Resources\WorkoutLogs\Schemas\WorkoutLogInfolist;
use App\Filament\Resources\WorkoutLogs\Tables\WorkoutLogsTable;
use App\Models\WorkoutLog;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WorkoutLogResource extends BaseResource
{
    protected static ?string $model = WorkoutLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?string $modelLabel = 'Registro de Treino';

    protected static ?string $pluralModelLabel = 'Registros de Treino';

    protected static ?string $navigationLabel = 'Registros de Treino';

    protected static string|UnitEnum|null $navigationGroup = 'Treino';

    public static function form(Schema $schema): Schema
    {
        return WorkoutLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WorkoutLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkoutLogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            LogExercisesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkoutLogs::route('/'),
            'create' => CreateWorkoutLog::route('/create'),
            'view' => ViewWorkoutLog::route('/{record}'),
            'edit' => EditWorkoutLog::route('/{record}/edit'),
        ];
    }
}
