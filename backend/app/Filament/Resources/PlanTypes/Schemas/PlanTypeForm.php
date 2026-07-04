<?php

namespace App\Filament\Resources\PlanTypes\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PlanTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Descrição')
                    ->rows(3)
                    ->nullable(),
                TextInput::make('amount_base')
                    ->label('Valor Base (R$)')
                    ->numeric()
                    ->step(0.01)
                    ->prefix('R$')
                    ->nullable(),
                TextInput::make('period_days')
                    ->label('Duração (dias)')
                    ->numeric()
                    ->minValue(1)
                    ->suffix('dias')
                    ->nullable(),
                Toggle::make('is_active')
                    ->label('Ativo')
                    ->default(true),
            ]);
    }
}
