<?php

namespace App\Filament\Resources\Students\RelationManagers;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';

    protected static ?string $relatedResource = BookingResource::class;

    protected static ?string $title = 'Eventos';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bookingType.name')
                    ->label('Tipo')
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Início')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Fim')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Pendente',
                        'confirmed' => 'Confirmado',
                        'cancelled' => 'Cancelado',
                        'completed' => 'Concluído',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('vacancies')
                    ->label('Vagas'),
            ])
            ->defaultSort('id', 'desc')
            ->headerActions([
                Action::make('createBooking')
                    ->label('Novo Evento')
                    ->color('primary')
                    ->url(fn () => BookingResource::getUrl('create')),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('Visualizar')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => BookingResource::getUrl('view', ['record' => $record])),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
