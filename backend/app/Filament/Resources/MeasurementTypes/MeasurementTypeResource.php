<?php

namespace App\Filament\Resources\MeasurementTypes;

use App\Filament\BaseResource;
use App\Filament\Resources\MeasurementTypes\Pages\CreateMeasurementType;
use App\Filament\Resources\MeasurementTypes\Pages\EditMeasurementType;
use App\Filament\Resources\MeasurementTypes\Pages\ListMeasurementTypes;
use App\Filament\Resources\MeasurementTypes\Schemas\MeasurementTypeForm;
use App\Filament\Resources\MeasurementTypes\Tables\MeasurementTypesTable;
use App\Models\MeasurementType;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MeasurementTypeResource extends BaseResource
{
    protected static ?string $model = MeasurementType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static ?string $modelLabel = 'Tipo de Medição Muscular';

    protected static ?string $pluralModelLabel = 'Tipos de Medição Muscular';

    protected static ?string $navigationLabel = 'Tipos de Medição Muscular';

    protected static ?int $navigationSort = 4;

    protected static string|UnitEnum|null $navigationGroup = 'Cadastros';

    public static function form(Schema $schema): Schema
    {
        return MeasurementTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeasurementTypesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMeasurementTypes::route('/'),
            'create' => CreateMeasurementType::route('/create'),
            'edit' => EditMeasurementType::route('/{record}/edit'),
        ];
    }
}
