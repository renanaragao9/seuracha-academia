<?php

namespace App\Filament\Resources\PlanTypes;

use App\Filament\BaseResource;
use App\Filament\Resources\PlanTypes\Pages\CreatePlanType;
use App\Filament\Resources\PlanTypes\Pages\EditPlanType;
use App\Filament\Resources\PlanTypes\Pages\ListPlanTypes;
use App\Filament\Resources\PlanTypes\Schemas\PlanTypeForm;
use App\Filament\Resources\PlanTypes\Tables\PlanTypesTable;
use App\Models\PlanType;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlanTypeResource extends BaseResource
{
    protected static ?string $model = PlanType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $modelLabel = 'Tipo de Plano';

    protected static ?string $pluralModelLabel = 'Tipos de Plano';

    protected static ?string $navigationLabel = 'Tipos de Plano';

    protected static ?int $navigationSort = 10;

    protected static string|UnitEnum|null $navigationGroup = 'Cadastros';

    public static function form(Schema $schema): Schema
    {
        return PlanTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlanTypesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlanTypes::route('/'),
            'create' => CreatePlanType::route('/create'),
            'edit' => EditPlanType::route('/{record}/edit'),
        ];
    }
}
