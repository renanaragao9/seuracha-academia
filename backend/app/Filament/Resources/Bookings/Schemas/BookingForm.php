<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pendente',
                        'confirmed' => 'Confirmado',
                        'cancelled' => 'Cancelado',
                        'completed' => 'Concluído',
                    ])
                    ->default('pending')
                    ->required(),

                Select::make('booking_type_id')
                    ->label('Tipo de Evento')
                    ->relationship('bookingType', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('vacancies')
                    ->label('Vagas')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->required(),

                TextInput::make('full_addresses')
                    ->label('Endereço Completo')
                    ->required(),

                DateTimePicker::make('start_date')
                    ->label('Data e Hora de Início')
                    ->displayFormat('d/m/Y H:i')
                    ->required(),

                DateTimePicker::make('end_date')
                    ->label('Data e Hora de Fim')
                    ->displayFormat('d/m/Y H:i')
                    ->required(),

                Textarea::make('description')
                    ->label('Descrição')
                    ->rows(3)
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }
}
