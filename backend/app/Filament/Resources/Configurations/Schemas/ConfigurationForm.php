<?php

namespace App\Filament\Resources\Configurations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConfigurationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Informações Básicas')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome da Academia')
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('cnpj')
                            ->label('CNPJ')
                            ->mask('99.999.999/9999-99')
                            ->nullable(),

                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->nullable(),

                        TextInput::make('phone')
                            ->label('Telefone')
                            ->mask('(99) 9999-9999')
                            ->nullable(),

                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->mask('(99) 9-9999-9999')
                            ->nullable(),

                        TextInput::make('emergency_phone')
                            ->label('Telefone de Emergência')
                            ->mask('(99) 9-9999-9999')
                            ->nullable(),

                        TextInput::make('website')
                            ->label('Website')
                            ->nullable(),

                        Textarea::make('description')
                            ->label('Descrição')
                            ->rows(3)
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Imagens')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('configurations')
                            ->nullable(),

                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->disk('public')
                            ->directory('configurations')
                            ->nullable(),
                    ]),

                Section::make('Endereço')
                    ->columnSpan(3)
                    ->columns(3)
                    ->schema([
                        TextInput::make('zip_code')
                            ->label('CEP')
                            ->mask('99999-999')
                            ->nullable(),

                        TextInput::make('address')
                            ->label('Endereço')
                            ->nullable()
                            ->columnSpan(2),

                        TextInput::make('number')
                            ->label('Número'),

                        TextInput::make('complement')
                            ->label('Complemento')
                            ->nullable()
                            ->columnSpan(2),

                        TextInput::make('neighborhood')
                            ->label('Bairro')
                            ->nullable(),

                        TextInput::make('city')
                            ->label('Cidade')
                            ->nullable(),

                        TextInput::make('state')
                            ->label('Estado')
                            ->maxLength(2)
                            ->nullable(),
                    ]),

                Section::make('Redes Sociais')
                    ->columnSpan(3)
                    ->columns(3)
                    ->schema([
                        TextInput::make('instagram')
                            ->label('Instagram')
                            ->prefix('@')
                            ->nullable(),

                        TextInput::make('facebook')
                            ->label('Facebook')
                            ->nullable(),

                        TextInput::make('youtube')
                            ->label('YouTube')
                            ->prefix('@')
                            ->nullable(),
                    ]),

                Section::make('Horários de Funcionamento')
                    ->columnSpan(3)
                    ->columns(2)
                    ->schema([
                        TimePicker::make('opening_time')
                            ->label('Horário de Abertura')
                            ->nullable(),

                        TimePicker::make('closing_time')
                            ->label('Horário de Fechamento')
                            ->nullable(),

                        Textarea::make('opening_hours')
                            ->label('Horários de Funcionamento (Descrição)')
                            ->rows(3)
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Notas')
                    ->columnSpan(3)
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notas Internas')
                            ->rows(4)
                            ->nullable(),
                    ]),
            ]);
    }
}
