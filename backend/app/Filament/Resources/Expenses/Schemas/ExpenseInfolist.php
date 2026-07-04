<?php

namespace App\Filament\Resources\Expenses\Schemas;

use App\Models\Expense;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExpenseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados da Despesa')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('expenseType.name')
                            ->label('Categoria'),

                        TextEntry::make('type')
                            ->label('Tipo')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'income' => 'Entrada',
                                'expense' => 'Saída',
                                default => $state,
                            }),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'paid' => 'success',
                                'overdue' => 'danger',
                                'cancelled' => 'gray',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => 'Pendente',
                                'paid' => 'Pago',
                                'overdue' => 'Vencido',
                                'cancelled' => 'Cancelado',
                                default => $state,
                            }),

                        TextEntry::make('date_maturity')
                            ->label('Data de Vencimento')
                            ->date('d/m/Y'),

                        TextEntry::make('total_amount')
                            ->label('Valor Total')
                            ->money('BRL'),

                        TextEntry::make('user.name')
                            ->label('Registrado por')
                            ->placeholder('-'),

                        TextEntry::make('description')
                            ->label('Descrição')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Auditoria')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('deleted_at')
                            ->label('Excluído em')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-')
                            ->visible(fn (Expense $record): bool => $record->trashed()),
                    ]),
            ]);
    }
}
