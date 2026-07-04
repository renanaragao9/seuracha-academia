<?php

namespace App\Filament\Resources\BookingTypes;

use App\Filament\BaseResource;
use App\Filament\Resources\BookingTypes\Pages\CreateBookingType;
use App\Filament\Resources\BookingTypes\Pages\EditBookingType;
use App\Filament\Resources\BookingTypes\Pages\ListBookingTypes;
use App\Filament\Resources\BookingTypes\Schemas\BookingTypeForm;
use App\Filament\Resources\BookingTypes\Tables\BookingTypesTable;
use App\Models\BookingType;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BookingTypeResource extends BaseResource
{
    protected static ?string $model = BookingType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $modelLabel = 'Tipo de Evento';

    protected static ?string $pluralModelLabel = 'Tipos de Evento';

    protected static ?string $navigationLabel = 'Tipos de Evento';

    protected static ?int $navigationSort = 11;

    protected static string|UnitEnum|null $navigationGroup = 'Cadastros';

    public static function form(Schema $schema): Schema
    {
        return BookingTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingTypesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookingTypes::route('/'),
            'create' => CreateBookingType::route('/create'),
            'edit' => EditBookingType::route('/{record}/edit'),
        ];
    }
}
