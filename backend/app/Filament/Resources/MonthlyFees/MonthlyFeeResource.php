<?php

namespace App\Filament\Resources\MonthlyFees;

use App\Filament\BaseResource;
use App\Filament\Resources\MonthlyFees\Pages\CreateMonthlyFee;
use App\Filament\Resources\MonthlyFees\Pages\EditMonthlyFee;
use App\Filament\Resources\MonthlyFees\Pages\ListMonthlyFees;
use App\Filament\Resources\MonthlyFees\Pages\ViewMonthlyFee;
use App\Filament\Resources\MonthlyFees\Schemas\MonthlyFeeForm;
use App\Filament\Resources\MonthlyFees\Schemas\MonthlyFeeInfolist;
use App\Filament\Resources\MonthlyFees\Tables\MonthlyFeesTable;
use App\Models\MonthlyFee;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MonthlyFeeResource extends BaseResource
{
    protected static ?string $model = MonthlyFee::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static ?string $modelLabel = 'Mensalidade';

    protected static ?string $pluralModelLabel = 'Mensalidades';

    protected static ?string $navigationLabel = 'Mensalidades';

    protected static string|UnitEnum|null $navigationGroup = 'Financeiro';

    public static function form(Schema $schema): Schema
    {
        return MonthlyFeeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MonthlyFeeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MonthlyFeesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMonthlyFees::route('/'),
            'create' => CreateMonthlyFee::route('/create'),
            'view' => ViewMonthlyFee::route('/{record}'),
            'edit' => EditMonthlyFee::route('/{record}/edit'),
        ];
    }
}
