<?php

namespace App\Filament\Resources\Sales\Tables;

use App\Filament\Actions\DownloadSaleReceiptAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date_sale')
                    ->label('Data da Venda')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('student.name')
                    ->label('Aluno')
                    ->placeholder('-')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->placeholder('-')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'paid' => 'Pago',
                        'open' => 'Aberto',
                        'canceled' => 'Cancelado',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'paid' => 'success',
                        'open' => 'warning',
                        'canceled' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('amount_price')
                    ->label('Subtotal')
                    ->money('BRL')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('discount_amount')
                    ->label('Desconto')
                    ->money('BRL')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('BRL')
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('user.name')
                    ->label('Vendedor')
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')

            ->filters([
                SelectFilter::make('student')
                    ->label('Aluno')
                    ->relationship('student', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('user')
                    ->label('Vendedor')
                    ->relationship('user', 'name', fn ($query) => $query->whereHas('role', fn ($q) => $q->where('name', '!=', 'Estudante')))
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'paid' => 'Pago',
                        'open' => 'Aberto',
                        'canceled' => 'Cancelado',
                    ]),

                SelectFilter::make('has_discount')
                    ->label('Desconto')
                    ->options([
                        'with_discount' => 'Com desconto',
                        'without_discount' => 'Sem desconto',
                    ])
                    ->query(fn ($query, array $data) => $query
                        ->when($data['value'] === 'with_discount', fn ($q) => $q->where('discount_amount', '>', 0))
                        ->when($data['value'] === 'without_discount', fn ($q) => $q->where('discount_amount', '=', 0)),
                    ),

                TrashedFilter::make()
                    ->label('Registros excluídos'),
            ])

            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                DownloadSaleReceiptAction::make(),
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
