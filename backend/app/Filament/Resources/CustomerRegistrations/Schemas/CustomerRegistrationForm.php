<?php

namespace App\Filament\Resources\CustomerRegistrations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class CustomerRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados do Registro')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required(),
                        TextInput::make('phone')
                            ->label('Telefone')
                            ->mask('(99) 9-9999-9999')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required(),
                        Select::make('plan_type_id')
                            ->label('Plano')
                            ->relationship(
                                name: 'planType',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query): Builder => $query
                                    ->where('is_active', true)
                                    ->orderBy('name'),
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        Textarea::make('message')
                            ->label('Mensagem')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
