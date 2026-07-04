<?php

namespace App\Filament\Resources\ItemTypes;

use App\Filament\BaseResource;
use App\Filament\Resources\ItemTypes\Pages\CreateItemType;
use App\Filament\Resources\ItemTypes\Pages\EditItemType;
use App\Filament\Resources\ItemTypes\Pages\ListItemTypes;
use App\Filament\Resources\ItemTypes\Schemas\ItemTypeForm;
use App\Filament\Resources\ItemTypes\Tables\ItemTypesTable;
use App\Models\ItemType;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ItemTypeResource extends BaseResource
{
    protected static ?string $model = ItemType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $modelLabel = 'Tipo de Produto';

    protected static ?string $pluralModelLabel = 'Tipos de Produtos';

    protected static ?string $navigationLabel = 'Tipos de Produtos';

    protected static ?int $navigationSort = 7;

    protected static string|UnitEnum|null $navigationGroup = 'Cadastros';

    public static function form(Schema $schema): Schema
    {
        return ItemTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ItemTypesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItemTypes::route('/'),
            'create' => CreateItemType::route('/create'),
            'edit' => EditItemType::route('/{record}/edit'),
        ];
    }
}
