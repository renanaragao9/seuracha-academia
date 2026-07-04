<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Booking;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados do Evento')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'confirmed' => 'success',
                                'cancelled' => 'danger',
                                'completed' => 'info',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => 'Pendente',
                                'confirmed' => 'Confirmado',
                                'cancelled' => 'Cancelado',
                                'completed' => 'Concluído',
                                default => $state,
                            }),

                        TextEntry::make('bookingType.name')
                            ->label('Tipo de Evento')
                            ->placeholder('-'),

                        TextEntry::make('vacancies')
                            ->label('Vagas')
                            ->badge()
                            ->color('gray'),

                        TextEntry::make('bookingStudents')
                            ->label('Reservas')
                            ->badge()
                            ->color(fn (Booking $record): string => $record->bookingStudents()->count() >= $record->vacancies ? 'danger' : 'success')
                            ->state(fn (Booking $record): int => $record->bookingStudents()->count()),

                        TextEntry::make('full_addresses')
                            ->label('Endereço Completo')
                            ->placeholder('-'),

                        TextEntry::make('user.name')
                            ->label('Registrado por')
                            ->placeholder('-'),

                        TextEntry::make('start_date')
                            ->label('Data e Hora de Início')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('end_date')
                            ->label('Data e Hora de Fim')
                            ->dateTime('d/m/Y H:i'),

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
                            ->visible(fn (Booking $record): bool => $record->trashed()),
                    ]),
            ]);
    }
}
