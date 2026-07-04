<?php

namespace App\Filament\Resources\TrainingSheets;

use App\Filament\BaseResource;
use App\Filament\Resources\TrainingSheets\Pages\CreateTrainingSheet;
use App\Filament\Resources\TrainingSheets\Pages\EditTrainingSheet;
use App\Filament\Resources\TrainingSheets\Pages\ListTrainingSheets;
use App\Filament\Resources\TrainingSheets\Pages\ViewTrainingSheet;
use App\Filament\Resources\TrainingSheets\RelationManagers\WorkoutLogsRelationManager;
use App\Filament\Resources\TrainingSheets\Schemas\TrainingSheetForm;
use App\Filament\Resources\TrainingSheets\Schemas\TrainingSheetInfolist;
use App\Filament\Resources\TrainingSheets\Tables\TrainingSheetsTable;
use App\Models\TrainingSheet;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TrainingSheetResource extends BaseResource
{
    protected static ?string $model = TrainingSheet::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $modelLabel = 'Ficha de Treino';

    protected static ?string $pluralModelLabel = 'Fichas de Treino';

    protected static ?string $navigationLabel = 'Fichas de Treino';

    protected static string|UnitEnum|null $navigationGroup = 'Treino';

    public static function form(Schema $schema): Schema
    {
        return TrainingSheetForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TrainingSheetInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingSheetsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            WorkoutLogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrainingSheets::route('/'),
            'create' => CreateTrainingSheet::route('/create'),
            'view' => ViewTrainingSheet::route('/{record}'),
            'edit' => EditTrainingSheet::route('/{record}/edit'),
        ];
    }
}
