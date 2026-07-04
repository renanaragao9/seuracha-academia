<?php

namespace App\Filament\Resources\CustomerRegistrations\Schemas;

use App\Models\CustomerRegistration;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerRegistrationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados do Registro')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome'),
                        TextEntry::make('phone')
                            ->label('Telefone'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('planType.name')
                            ->label('Plano'),
                        TextEntry::make('message')
                            ->label('Mensagem')
                            ->columnSpanFull(),
                    ]),

                Section::make('Auditoria')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('deleted_at')
                            ->label('Deletado em')
                            ->dateTime()
                            ->visible(fn (CustomerRegistration $record): bool => $record->trashed()),
                    ]),
            ]);
    }
}
