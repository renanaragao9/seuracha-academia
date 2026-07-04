<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SaleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->schema([
                Section::make('Informações da Venda')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        TextEntry::make('uuid')
                            ->label('ID da Transação')
                            ->copyable(),

                        TextEntry::make('date_sale')
                            ->label('Data da Venda')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('student.name')
                            ->label('Aluno')
                            ->placeholder('-'),

                        TextEntry::make('user.name')
                            ->label('Registrado por')
                            ->placeholder('-'),

                        TextEntry::make('observation')
                            ->label('Observação')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Resumo Financeiro')
                    ->columnSpan(1)
                    ->schema([
                        TextEntry::make('amount_price')
                            ->label('Subtotal dos Produtos')
                            ->money('BRL'),

                        TextEntry::make('discount_amount')
                            ->label('Desconto')
                            ->money('BRL'),

                        TextEntry::make('total_amount')
                            ->label('Total a Pagar')
                            ->money('BRL')
                            ->weight('bold')
                            ->color('success'),
                    ]),

                Section::make('Auditoria')
                    ->columnSpanFull()
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
                    ]),

                Section::make('Produtos da Venda')
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('saleItems')
                            ->label('Produtos')
                            ->columns(4)
                            ->schema([
                                TextEntry::make('item.name')
                                    ->label('Produto')
                                    ->columnSpan(2),

                                TextEntry::make('quantity')
                                    ->label('Qtd.')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('unit_price')
                                    ->label('Preço Unit.')
                                    ->money('BRL'),

                                TextEntry::make('subtotal')
                                    ->label('Subtotal')
                                    ->money('BRL')
                                    ->weight('bold')
                                    ->badge()
                                    ->color('success'),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
