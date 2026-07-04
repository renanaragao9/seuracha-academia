<?php

namespace App\Filament\Resources\Configurations;

use App\Filament\BaseResource;
use App\Filament\Resources\Configurations\Pages\EditConfiguration;
use App\Filament\Resources\Configurations\Pages\ListConfigurations;
use App\Filament\Resources\Configurations\Pages\ViewConfiguration;
use App\Filament\Resources\Configurations\Schemas\ConfigurationForm;
use App\Filament\Resources\Configurations\Schemas\ConfigurationInfolist;
use App\Filament\Resources\Configurations\Tables\ConfigurationsTable;
use App\Models\Configuration;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ConfigurationResource extends BaseResource
{
    protected static ?string $model = Configuration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $modelLabel = 'Configuração';

    protected static ?string $pluralModelLabel = 'Configurações';

    protected static ?string $navigationLabel = 'Configurações';

    protected static string|UnitEnum|null $navigationGroup = 'Cadastros';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ConfigurationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ConfigurationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConfigurationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConfigurations::route('/'),
            'view' => ViewConfiguration::route('/{record}'),
            'edit' => EditConfiguration::route('/{record}/edit'),
        ];
    }
}
