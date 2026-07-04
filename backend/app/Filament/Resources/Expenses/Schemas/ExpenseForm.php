<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'income' => 'Entrada',
                        'expense' => 'Saída',
                    ])
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pendente',
                        'paid' => 'Pago',
                        'overdue' => 'Vencido',
                        'cancelled' => 'Cancelado',
                    ])
                    ->default('pending')
                    ->required(),

                Select::make('expense_type_id')
                    ->label('Categoria')
                    ->relationship('expenseType', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('date_maturity')
                    ->label('Data de Vencimento')
                    ->displayFormat('d/m/Y')
                    ->required(),

                TextInput::make('total_amount')
                    ->label('Valor Total')
                    ->numeric()
                    ->step(0.01)
                    ->prefix('R$')
                    ->required(),

                Textarea::make('description')
                    ->label('Descrição')
                    ->rows(3)
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }
}
