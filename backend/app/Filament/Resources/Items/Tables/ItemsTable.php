<?php

namespace App\Filament\Resources\Items\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('itemType.name')
                    ->label('Tipo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('total_price')
                    ->label('Preço Total')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('promotion_price')
                    ->label('Preço de Promoção')
                    ->money('BRL')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Descrição')
                    ->placeholder('-')
                    ->limit(50)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('itemType')
                    ->label('Tipo')
                    ->relationship('itemType', 'name')
                    ->searchable(),

                Filter::make('total_price')
                    ->label('Preço Total')
                    ->form([
                        TextInput::make('from')
                            ->label('Preço total mín.')
                            ->numeric(),
                        TextInput::make('until')
                            ->label('Preço total máx.')
                            ->numeric(),
                    ])
                    ->query(fn (Builder $query, array $data) => $query
                        ->when($data['from'], fn ($q, $price) => $q->where('total_price', '>=', $price))
                        ->when($data['until'], fn ($q, $price) => $q->where('total_price', '<=', $price)),
                    ),

                Filter::make('promotion_price')
                    ->label('Preço Promocional')
                    ->form([
                        TextInput::make('from')
                            ->label('Preço prom. mín.')
                            ->numeric(),
                        TextInput::make('until')
                            ->label('Preço prom. máx.')
                            ->numeric(),
                    ])
                    ->query(fn (Builder $query, array $data) => $query
                        ->when($data['from'], fn ($q, $price) => $q->where('promotion_price', '>=', $price))
                        ->when($data['until'], fn ($q, $price) => $q->where('promotion_price', '<=', $price)),
                    ),

                TrashedFilter::make()
                    ->label('Registros excluídos'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
