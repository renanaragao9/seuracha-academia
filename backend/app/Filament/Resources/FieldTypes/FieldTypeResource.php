<?php

namespace App\Filament\Resources\FieldTypes;

use App\Filament\BaseResource;
use App\Filament\Resources\FieldTypes\Pages\CreateFieldType;
use App\Filament\Resources\FieldTypes\Pages\EditFieldType;
use App\Filament\Resources\FieldTypes\Pages\ListFieldTypes;
use App\Filament\Resources\FieldTypes\Schemas\FieldTypeForm;
use App\Filament\Resources\FieldTypes\Tables\FieldTypesTable;
use App\Models\FieldType;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FieldTypeResource extends BaseResource
{
    protected static ?string $model = FieldType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquare3Stack3d;

    protected static ?string $modelLabel = 'Tipo de Campo do Item';

    protected static ?string $pluralModelLabel = 'Tipos de Campo do Item';

    protected static ?string $navigationLabel = 'Tipos de Campo do Item';

    protected static ?int $navigationSort = 8;

    protected static string|UnitEnum|null $navigationGroup = 'Cadastros';

    public static function form(Schema $schema): Schema
    {
        return FieldTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FieldTypesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFieldTypes::route('/'),
            'create' => CreateFieldType::route('/create'),
            'edit' => EditFieldType::route('/{record}/edit'),
        ];
    }
}
