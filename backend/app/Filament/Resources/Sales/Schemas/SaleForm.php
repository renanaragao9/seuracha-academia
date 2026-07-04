<?php

namespace App\Filament\Resources\Sales\Schemas;

use App\Models\Item;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class SaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                // Coluna esquerda — 2/3 da largura
                Section::make('Informações da Venda')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        DateTimePicker::make('date_sale')
                            ->label('Data da Venda')
                            ->displayFormat('d/m/Y H:i')
                            ->default(now())
                            ->required(),

                        Select::make('student_id')
                            ->label('Aluno')
                            ->relationship('student', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'paid' => 'Pago',
                                'open' => 'Aberto',
                                'canceled' => 'Cancelado',
                            ])
                            ->nullable(),

                        Textarea::make('observation')
                            ->label('Observação')
                            ->rows(3)
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                // Coluna direita — 1/3 da largura
                Section::make('Totais')
                    ->columnSpan(1)
                    ->schema([
                        TextInput::make('discount_amount')
                            ->label('Desconto (R$)')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('R$')
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set): void {
                                self::recalculateTotals($get, $set);
                            }),

                        TextInput::make('amount_price')
                            ->label('Subtotal dos Produtos')
                            ->numeric()
                            ->prefix('R$')
                            ->disabled()
                            ->dehydrated()
                            ->default(0),

                        TextInput::make('total_amount')
                            ->label('Total a Pagar')
                            ->numeric()
                            ->prefix('R$')
                            ->disabled()
                            ->dehydrated()
                            ->default(0),
                    ]),

                // Linha completa abaixo — itens da venda
                Section::make('Produtos da Venda')
                    ->columnSpanFull()
                    ->description('Adicione os produtos que fazem parte desta venda.')
                    ->schema([
                        Repeater::make('saleItems')
                            ->label('Produtos')
                            ->relationship()
                            ->collapsible()
                            ->collapsed(false)
                            ->itemLabel(fn (array $state): ?string => Item::find($state['item_id'])?->name ?? 'Produto')
                            ->defaultItems(1)
                            ->addActionLabel('Adicionar Produto')
                            ->columns(4)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set): void {
                                self::recalculateTotals($get, $set);
                            })
                            ->schema([
                                Select::make('item_id')
                                    ->label('Produto')
                                    ->options(fn () => Item::orderBy('name')->pluck('name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->afterStateUpdated(function (Get $get, Set $set, $state): void {
                                        if (! $state) {
                                            return;
                                        }

                                        $item = Item::find($state);

                                        if (! $item) {
                                            return;
                                        }

                                        $price = (float) ($item->promotion_price ?? $item->total_price);
                                        $qty = (int) ($get('quantity') ?: 1);

                                        $set('unit_price', $price);
                                        $set('subtotal', round($price * $qty, 2));
                                    })
                                    ->columnSpan(2),

                                TextInput::make('quantity')
                                    ->label('Qtd.')
                                    ->numeric()
                                    ->minValue(1)
                                    ->step(1)
                                    ->default(1)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set, $state): void {
                                        $price = (float) $get('unit_price');
                                        $set('subtotal', round($price * (int) $state, 2));
                                    }),

                                TextInput::make('unit_price')
                                    ->label('Preço Unit.')
                                    ->numeric()
                                    ->step(0.01)
                                    ->prefix('R$')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set, $state): void {
                                        $qty = (int) ($get('quantity') ?: 1);
                                        $set('subtotal', round((float) $state * $qty, 2));
                                    }),

                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->prefix('R$')
                                    ->disabled()
                                    ->dehydrated()
                                    ->default(0),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    private static function recalculateTotals(Get $get, Set $set): void
    {
        $items = $get('saleItems') ?? [];
        $subtotal = collect($items)->sum(fn ($item) => (float) ($item['subtotal'] ?? 0));
        $discount = (float) ($get('discount_amount') ?? 0);

        $set('amount_price', round($subtotal, 2));
        $set('total_amount', round(max(0, $subtotal - $discount), 2));
    }
}
