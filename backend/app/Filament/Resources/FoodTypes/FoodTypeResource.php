<?php

namespace App\Filament\Resources\FoodTypes;

use App\Filament\BaseResource;
use App\Filament\Resources\FoodTypes\Pages\CreateFoodType;
use App\Filament\Resources\FoodTypes\Pages\EditFoodType;
use App\Filament\Resources\FoodTypes\Pages\ListFoodTypes;
use App\Filament\Resources\FoodTypes\Schemas\FoodTypeForm;
use App\Filament\Resources\FoodTypes\Tables\FoodTypesTable;
use App\Models\FoodType;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FoodTypeResource extends BaseResource
{
    protected static ?string $model = FoodType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCake;

    protected static ?string $modelLabel = 'Tipo de Alimento';

    protected static ?string $pluralModelLabel = 'Tipos de Alimento';

    protected static ?string $navigationLabel = 'Tipos de Alimento';

    protected static ?int $navigationSort = 6;

    protected static string|UnitEnum|null $navigationGroup = 'Cadastros';

    public static function form(Schema $schema): Schema
    {
        return FoodTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FoodTypesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFoodTypes::route('/'),
            'create' => CreateFoodType::route('/create'),
            'edit' => EditFoodType::route('/{record}/edit'),
        ];
    }
}
