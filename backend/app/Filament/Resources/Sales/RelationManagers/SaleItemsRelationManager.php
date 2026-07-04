<?php

namespace App\Filament\Resources\Sales\RelationManagers;

use App\Models\Item;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SaleItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'saleItems';

    protected static ?string $title = 'Itens da Venda';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                Select::make('item_id')
                    ->label('Item')
                    ->relationship(
                        name: 'item',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query, $record) => $query->when(
                            $record === null,
                            fn ($q) => $q->whereNotIn('id', $this->getOwnerRecord()->saleItems()->pluck('item_id'))
                        ),
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set, $state): void {
                        if (! $state) {
                            return;
                        }

                        $item = Item::find($state);

                        if (! $item) {
                            return;
                        }

                        $price = $item->promotion_price ?? $item->total_price;
                        $set('unit_price', $price);
                        $set('subtotal', round($price * ($get('quantity') ?: 1), 2));
                    })
                    ->columnSpanFull(),

                TextInput::make('quantity')
                    ->label('Quantidade')
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
                    ->label('Preço Unitário')
                    ->numeric()
                    ->step(0.01)
                    ->prefix('R$')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, $state): void {
                        $qty = (int) $get('quantity') ?: 1;
                        $set('subtotal', round((float) $state * $qty, 2));
                    }),

                TextInput::make('subtotal')
                    ->label('Subtotal')
                    ->numeric()
                    ->step(0.01)
                    ->prefix('R$')
                    ->disabled()
                    ->dehydrated()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('item.name')
                    ->label('Item')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('quantity')
                    ->label('Qtd.')
                    ->sortable(),

                TextColumn::make('unit_price')
                    ->label('Preço Unitário')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('BRL')
                    ->sortable()
                    ->weight('bold'),
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label('Adicionar Item'),
            ]);
    }
}
