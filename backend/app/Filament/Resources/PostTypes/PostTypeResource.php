<?php

namespace App\Filament\Resources\PostTypes;

use App\Filament\BaseResource;
use App\Filament\Resources\PostTypes\Pages\CreatePostType;
use App\Filament\Resources\PostTypes\Pages\EditPostType;
use App\Filament\Resources\PostTypes\Pages\ListPostTypes;
use App\Filament\Resources\PostTypes\Schemas\PostTypeForm;
use App\Filament\Resources\PostTypes\Tables\PostTypesTable;
use App\Models\PostType;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PostTypeResource extends BaseResource
{
    protected static ?string $model = PostType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $modelLabel = 'Tipo de Postagem';

    protected static ?string $pluralModelLabel = 'Tipos de Postagem';

    protected static ?string $navigationLabel = 'Tipos de Postagem';

    protected static ?int $navigationSort = 9;

    protected static string|UnitEnum|null $navigationGroup = 'Cadastros';

    public static function form(Schema $schema): Schema
    {
        return PostTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostTypesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPostTypes::route('/'),
            'create' => CreatePostType::route('/create'),
            'edit' => EditPostType::route('/{record}/edit'),
        ];
    }
}
