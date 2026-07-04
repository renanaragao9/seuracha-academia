<?php

namespace App\Filament\Resources\Exercises;

use App\Filament\BaseResource;
use App\Filament\Resources\Exercises\Pages\CreateExercise;
use App\Filament\Resources\Exercises\Pages\EditExercise;
use App\Filament\Resources\Exercises\Pages\ListExercises;
use App\Filament\Resources\Exercises\Pages\ViewExercise;
use App\Filament\Resources\Exercises\Schemas\ExerciseForm;
use App\Filament\Resources\Exercises\Schemas\ExerciseInfolist;
use App\Filament\Resources\Exercises\Tables\ExercisesTable;
use App\Models\Exercise;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ExerciseResource extends BaseResource
{
    protected static ?string $model = Exercise::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBolt;

    protected static ?string $modelLabel = 'Exercício';

    protected static ?string $pluralModelLabel = 'Exercícios';

    protected static ?string $navigationLabel = 'Exercícios';

    protected static string|UnitEnum|null $navigationGroup = 'Treino';

    public static function form(Schema $schema): Schema
    {
        return ExerciseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExerciseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExercisesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExercises::route('/'),
            'create' => CreateExercise::route('/create'),
            'view' => ViewExercise::route('/{record}'),
            'edit' => EditExercise::route('/{record}/edit'),
        ];
    }
}
