<?php

namespace App\Filament\Resources\Students\RelationManagers;

use App\Filament\Actions\DownloadSaleReceiptAction;
use App\Filament\Resources\Sales\SaleResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SalesRelationManager extends RelationManager
{
    protected static string $relationship = 'sales';

    protected static ?string $relatedResource = SaleResource::class;

    protected static ?string $title = 'Compras';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date_sale')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
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

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('BRL')
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('user.name')
                    ->label('Vendedor')
                    ->placeholder('-'),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->headerActions([
                Action::make('createSale')
                    ->label('Nova Venda')
                    ->color('primary')
                    ->url(fn () => SaleResource::getUrl('create', [
                        'student_id' => $this->getOwnerRecord()->getKey(),
                    ])),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                DownloadSaleReceiptAction::make(),
            ]);
    }
}
