<?php

namespace App\Filament\Resources\Students;

use App\Filament\BaseResource;
use App\Filament\Resources\Students\Pages\CreateStudent;
use App\Filament\Resources\Students\Pages\EditStudent;
use App\Filament\Resources\Students\Pages\ListStudents;
use App\Filament\Resources\Students\Pages\ViewStudent;
use App\Filament\Resources\Students\RelationManagers\AssessmentsRelationManager;
use App\Filament\Resources\Students\RelationManagers\BookingsRelationManager;
use App\Filament\Resources\Students\RelationManagers\MealPlansRelationManager;
use App\Filament\Resources\Students\RelationManagers\MonthlyFeesRelationManager;
use App\Filament\Resources\Students\RelationManagers\SalesRelationManager;
use App\Filament\Resources\Students\RelationManagers\TrainingSheetsRelationManager;
use App\Filament\Resources\Students\RelationManagers\WorkoutLogsRelationManager;
use App\Filament\Resources\Students\Schemas\StudentForm;
use App\Filament\Resources\Students\Schemas\StudentInfolist;
use App\Filament\Resources\Students\Tables\StudentsTable;
use App\Models\Student;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StudentResource extends BaseResource
{
    protected static ?string $model = Student::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $modelLabel = 'Aluno';

    protected static ?string $pluralModelLabel = 'Alunos';

    protected static ?string $navigationLabel = 'Alunos';

    protected static string|UnitEnum|null $navigationGroup = 'Gestão';

    public static function form(Schema $schema): Schema
    {
        return StudentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MonthlyFeesRelationManager::class,
            TrainingSheetsRelationManager::class,
            AssessmentsRelationManager::class,
            MealPlansRelationManager::class,
            WorkoutLogsRelationManager::class,
            SalesRelationManager::class,
            BookingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'view' => ViewStudent::route('/{record}'),
            'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}
