<?php

namespace App\Filament\Resources\MonthlyFees\Schemas;

use App\Models\MonthlyFee;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MonthlyFeeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados da Mensalidade')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('student.name')
                            ->label('Aluno')
                            ->columnSpanFull(),

                        TextEntry::make('planType.name')
                            ->label('Plano'),

                        TextEntry::make('paymentType.name')
                            ->label('Forma de Pagamento'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->placeholder('-')
                            ->formatStateUsing(fn ($state) => match ($state) {
                                'paid' => 'Pago',
                                'pending' => 'Pendente',
                                'overdue' => 'Vencido',
                                'cancelled' => 'Cancelado',
                                'refunded' => 'Reembolsado',
                                default => $state,
                            })
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'paid' => 'success',
                                'pending' => 'warning',
                                'overdue' => 'danger',
                                'cancelled' => 'gray',
                                'refunded' => 'info',
                                default => 'gray',
                            }),

                        TextEntry::make('start_date')
                            ->label('Início da Vigência')
                            ->date('d/m/Y'),

                        TextEntry::make('end_date')
                            ->label('Fim da Vigência')
                            ->date('d/m/Y'),

                        TextEntry::make('date_payment')
                            ->label('Data do Pagamento')
                            ->date('d/m/Y')
                            ->placeholder('-'),

                        TextEntry::make('full_payment')
                            ->label('Valor do Plano')
                            ->money('BRL'),

                        TextEntry::make('discount_payment')
                            ->label('Desconto')
                            ->money('BRL')
                            ->placeholder('-'),

                        TextEntry::make('amount_paid')
                            ->label('Valor Pago')
                            ->money('BRL')
                            ->placeholder('-')
                            ->weight('bold')
                            ->color('success'),

                        TextEntry::make('final_payment')
                            ->label('Valor Final')
                            ->money('BRL')
                            ->state(fn (MonthlyFee $record): float => $record->final_payment),
                    ]),

                Section::make('Responsável')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Professor / Responsável')
                            ->placeholder('-'),

                        TextEntry::make('uuid')
                            ->label('ID da Transação')
                            ->placeholder('-'),

                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i'),
                    ]),
            ]);
    }
}
