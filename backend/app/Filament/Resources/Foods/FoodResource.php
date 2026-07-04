<?php

namespace App\Filament\Resources\Foods;

use App\Filament\BaseResource;
use App\Filament\Resources\Foods\Pages\CreateFood;
use App\Filament\Resources\Foods\Pages\EditFood;
use App\Filament\Resources\Foods\Pages\ListFoods;
use App\Filament\Resources\Foods\Pages\ViewFood;
use App\Filament\Resources\Foods\Schemas\FoodForm;
use App\Filament\Resources\Foods\Schemas\FoodInfolist;
use App\Filament\Resources\Foods\Tables\FoodsTable;
use App\Models\Food;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FoodResource extends BaseResource
{
    protected static ?string $model = Food::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static ?string $modelLabel = 'Alimento';

    protected static ?string $pluralModelLabel = 'Alimentos';

    protected static ?string $navigationLabel = 'Alimentos';

    protected static string|UnitEnum|null $navigationGroup = 'Nutrição';

    public static function form(Schema $schema): Schema
    {
        return FoodForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FoodInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FoodsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFoods::route('/'),
            'create' => CreateFood::route('/create'),
            'view' => ViewFood::route('/{record}'),
            'edit' => EditFood::route('/{record}/edit'),
        ];
    }
}
