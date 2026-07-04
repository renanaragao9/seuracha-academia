<?php

namespace App\Filament\Resources\WorkoutLogs\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkoutLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados do Treino')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('student.name')
                            ->label('Aluno')
                            ->placeholder('-'),
                        TextEntry::make('trainingSheet.name')
                            ->label('Ficha')
                            ->placeholder('-'),
                        TextEntry::make('sheetDivision.trainingDivision.name')
                            ->label('Divisão')
                            ->formatStateUsing(fn ($state): string => filled($state) ? 'Treino '.$state : '-')
                            ->placeholder('-'),
                        TextEntry::make('validator.name')
                            ->label('Validado por')
                            ->placeholder('-'),
                        TextEntry::make('started_at')
                            ->label('Início')
                            ->dateTime('d/m/Y H:i'),
                        TextEntry::make('finished_at')
                            ->label('Fim')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-'),
                        TextEntry::make('duration_minutes')
                            ->label('Duração')
                            ->suffix(' min')
                            ->placeholder('-'),
                        IconEntry::make('has_finished')
                            ->label('Finalizado')
                            ->state(fn ($record): bool => filled($record->finished_at))
                            ->boolean(),
                    ]),

                Section::make('Auditoria')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
