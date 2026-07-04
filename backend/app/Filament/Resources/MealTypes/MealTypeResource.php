<?php

namespace App\Filament\Resources\MealTypes;

use App\Filament\BaseResource;
use App\Filament\Resources\MealTypes\Pages\CreateMealType;
use App\Filament\Resources\MealTypes\Pages\EditMealType;
use App\Filament\Resources\MealTypes\Pages\ListMealTypes;
use App\Filament\Resources\MealTypes\Schemas\MealTypeForm;
use App\Filament\Resources\MealTypes\Tables\MealTypesTable;
use App\Models\MealType;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MealTypeResource extends BaseResource
{
    protected static ?string $model = MealType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;

    protected static ?string $modelLabel = 'Tipo de Refeição';

    protected static ?string $pluralModelLabel = 'Tipos de Refeição';

    protected static ?string $navigationLabel = 'Tipos de Refeição';

    protected static ?int $navigationSort = 5;

    protected static string|UnitEnum|null $navigationGroup = 'Cadastros';

    public static function form(Schema $schema): Schema
    {
        return MealTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MealTypesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMealTypes::route('/'),
            'create' => CreateMealType::route('/create'),
            'edit' => EditMealType::route('/{record}/edit'),
        ];
    }
}
