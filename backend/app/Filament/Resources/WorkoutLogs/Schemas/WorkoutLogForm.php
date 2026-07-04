<?php

namespace App\Filament\Resources\WorkoutLogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class WorkoutLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados do Treino')
                    ->columns(2)
                    ->schema([
                        Select::make('student_id')
                            ->label('Aluno')
                            ->relationship('student', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('training_sheet_id')
                            ->label('Ficha')
                            ->relationship('trainingSheet', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('training_sheet_division_id')
                            ->label('Divisão da Ficha')
                            ->relationship(
                                name: 'sheetDivision',
                                titleAttribute: 'id',
                                modifyQueryUsing: fn (Builder $query): Builder => $query
                                    ->with('trainingDivision')
                                    ->orderBy('training_sheet_id')
                                    ->orderBy('order')
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record): string => 'Treino '.($record->trainingDivision?->name ?? '-').' (Ficha #'.$record->training_sheet_id.')')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('validated_by')
                            ->label('Validado por')
                            ->relationship('validator', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        DateTimePicker::make('started_at')
                            ->label('Início')
                            ->seconds(false)
                            ->required(),

                        DateTimePicker::make('finished_at')
                            ->label('Fim')
                            ->seconds(false)
                            ->nullable(),

                        TextInput::make('duration_minutes')
                            ->label('Duração')
                            ->numeric()
                            ->minValue(0)
                            ->suffix('min')
                            ->nullable(),
                    ]),
            ]);
    }
}
