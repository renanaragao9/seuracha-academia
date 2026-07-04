<?php

namespace App\Filament\Resources\MuscleGroups;

use App\Filament\BaseResource;
use App\Filament\Resources\MuscleGroups\Pages\CreateMuscleGroup;
use App\Filament\Resources\MuscleGroups\Pages\EditMuscleGroup;
use App\Filament\Resources\MuscleGroups\Pages\ListMuscleGroups;
use App\Filament\Resources\MuscleGroups\Schemas\MuscleGroupForm;
use App\Filament\Resources\MuscleGroups\Tables\MuscleGroupsTable;
use App\Models\MuscleGroup;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MuscleGroupResource extends BaseResource
{
    protected static ?string $model = MuscleGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFire;

    protected static ?string $modelLabel = 'Grupo Muscular';

    protected static ?string $pluralModelLabel = 'Grupos Musculares';

    protected static ?string $navigationLabel = 'Grupos Musculares';

    protected static ?int $navigationSort = 2;

    protected static string|UnitEnum|null $navigationGroup = 'Cadastros';

    public static function form(Schema $schema): Schema
    {
        return MuscleGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MuscleGroupsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMuscleGroups::route('/'),
            'create' => CreateMuscleGroup::route('/create'),
            'edit' => EditMuscleGroup::route('/{record}/edit'),
        ];
    }
}
