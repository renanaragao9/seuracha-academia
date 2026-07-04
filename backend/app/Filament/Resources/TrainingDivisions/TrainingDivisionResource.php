<?php

namespace App\Filament\Resources\TrainingDivisions;

use App\Filament\BaseResource;
use App\Filament\Resources\TrainingDivisions\Pages\CreateTrainingDivision;
use App\Filament\Resources\TrainingDivisions\Pages\EditTrainingDivision;
use App\Filament\Resources\TrainingDivisions\Pages\ListTrainingDivisions;
use App\Filament\Resources\TrainingDivisions\Schemas\TrainingDivisionForm;
use App\Filament\Resources\TrainingDivisions\Tables\TrainingDivisionsTable;
use App\Models\TrainingDivision;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TrainingDivisionResource extends BaseResource
{
    protected static ?string $model = TrainingDivision::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Divisão de Treino';

    protected static ?string $pluralModelLabel = 'Divisões de Treino';

    protected static ?string $navigationLabel = 'Divisões de Treino';

    protected static ?int $navigationSort = 1;

    protected static string|UnitEnum|null $navigationGroup = 'Cadastros';

    public static function form(Schema $schema): Schema
    {
        return TrainingDivisionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingDivisionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrainingDivisions::route('/'),
            'create' => CreateTrainingDivision::route('/create'),
            'edit' => EditTrainingDivision::route('/{record}/edit'),
        ];
    }
}
