<?php

namespace App\Filament\Resources\CustomerRegistrations\Pages;

use App\Filament\Resources\CustomerRegistrations\CustomerRegistrationResource;
use App\Filament\Resources\Students\StudentResource;
use App\Models\CustomerRegistration;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomerRegistration extends ViewRecord
{
    protected static ?string $title = 'Visualizar Pré Cadastro de Cliente';

    protected static string $resource = CustomerRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_student')
                ->label('Criar Aluno')
                ->icon('heroicon-o-user-plus')
                ->color('success')
                ->url(fn (CustomerRegistration $record) => StudentResource::getUrl('create', [
                    'name' => $record->name,
                    'email' => $record->email,
                    'phone' => $record->phone,
                ])),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
