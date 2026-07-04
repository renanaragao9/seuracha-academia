<?php

namespace App\Filament\Resources\CustomerRegistrations;

use App\Filament\BaseResource;
use App\Filament\Resources\CustomerRegistrations\Pages\CreateCustomerRegistration;
use App\Filament\Resources\CustomerRegistrations\Pages\EditCustomerRegistration;
use App\Filament\Resources\CustomerRegistrations\Pages\ListCustomerRegistrations;
use App\Filament\Resources\CustomerRegistrations\Pages\ViewCustomerRegistration;
use App\Filament\Resources\CustomerRegistrations\Schemas\CustomerRegistrationForm;
use App\Filament\Resources\CustomerRegistrations\Schemas\CustomerRegistrationInfolist;
use App\Filament\Resources\CustomerRegistrations\Tables\CustomerRegistrationsTable;
use App\Models\CustomerRegistration;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CustomerRegistrationResource extends BaseResource
{
    protected static ?string $model = CustomerRegistration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserPlus;

    protected static ?string $modelLabel = 'Pré Cadastro de Aluno';

    protected static ?string $pluralModelLabel = 'Pré Cadastros de Alunos';

    protected static ?string $navigationLabel = 'Pré Cadastros de Alunos';

    protected static string|UnitEnum|null $navigationGroup = 'Gestão';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CustomerRegistrationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CustomerRegistrationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomerRegistrationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCustomerRegistrations::route('/'),
            'create' => CreateCustomerRegistration::route('/create'),
            'view' => ViewCustomerRegistration::route('/{record}'),
            'edit' => EditCustomerRegistration::route('/{record}/edit'),
        ];
    }
}
