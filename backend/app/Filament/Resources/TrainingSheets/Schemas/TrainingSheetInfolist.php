<?php

namespace App\Filament\Resources\TrainingSheets\Schemas;

use App\Models\TrainingSheet;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingSheetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados da Ficha')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->id('dados-da-ficha')
                    ->extraAttributes(['id' => 'section-dados-da-ficha'])
                    ->schema([
                        TextEntry::make('name')
                            ->label('Ficha'),

                        TextEntry::make('student.name')
                            ->label('Aluno')
                            ->placeholder('-'),

                        TextEntry::make('start_date')
                            ->label('Início')
                            ->date('d/m/Y')
                            ->placeholder('-'),

                        TextEntry::make('end_date')
                            ->label('Fim')
                            ->date('d/m/Y')
                            ->placeholder('-'),

                        IconEntry::make('is_active')
                            ->label('Ativa')
                            ->boolean(),

                        TextEntry::make('division_total')
                            ->label('Total de Divisões')
                            ->state(fn (TrainingSheet $record): int => (int) $record->divisions()->count()),
                    ]),

                Section::make('Auditoria')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes(['id' => 'section-auditoria'])
                    ->schema([
                        TextEntry::make('creator.name')
                            ->label('Criado por')
                            ->placeholder('-'),

                        TextEntry::make('updater.name')
                            ->label('Atualizado por')
                            ->placeholder('-'),

                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-'),

                        TextEntry::make('deleted_at')
                            ->label('Excluído em')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-')
                            ->visible(fn (TrainingSheet $record): bool => $record->trashed())
                            ->columnSpanFull(),
                    ]),

                Section::make('Divisões e Exercícios')
                    ->description('Visualização completa da ficha com ordem de divisões e exercícios.')
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes(['id' => 'section-divisoes-exercicios'])
                    ->schema([
                        RepeatableEntry::make('division_snapshot')
                            ->label('Divisões da Ficha')
                            ->state(function (TrainingSheet $record): array {
                                return $record->divisions()
                                    ->with(['trainingDivision', 'exercises.exercise'])
                                    ->orderBy('order')
                                    ->get()
                                    ->map(function ($division): array {
                                        return [
                                            'division_name' => 'Treino '.($division->trainingDivision?->name ?? '-'),
                                            'exercise_total' => $division->exercises->count(),
                                            'exercises' => $division->exercises
                                                ->sortBy('order')
                                                ->values()
                                                ->map(fn ($exercise): array => [
                                                    'exercise_order' => $exercise->order,
                                                    'exercise_name' => $exercise->exercise?->name ?? '-',
                                                    'series' => $exercise->series,
                                                    'repetitions' => $exercise->repetitions,
                                                    'rest_seconds' => $exercise->rest_seconds,
                                                    'load' => $exercise->load,
                                                    'observation' => $exercise->observation,
                                                ])
                                                ->all(),
                                        ];
                                    })
                                    ->all();
                            })
                            ->schema([
                                TextEntry::make('division_name')
                                    ->label('Divisão')
                                    ->weight('bold')
                                    ->size('lg')
                                    ->columnSpan(2),

                                TextEntry::make('exercise_total')
                                    ->label('Qtd. Exercícios')
                                    ->badge(),

                                RepeatableEntry::make('exercises')
                                    ->label('Exercícios')
                                    ->contained(true)
                                    ->columns(6)
                                    ->extraAttributes(['class' => 'divide-y divide-gray-100 dark:divide-gray-700'])
                                    ->schema([
                                        TextEntry::make('exercise_order')
                                            ->label('#')
                                            ->badge()
                                            ->color('gray'),

                                        TextEntry::make('exercise_name')
                                            ->label('Exercício')
                                            ->weight('medium')
                                            ->columnSpan(2),

                                        TextEntry::make('series')
                                            ->label('Séries')
                                            ->badge()
                                            ->color('info')
                                            ->placeholder('-'),

                                        TextEntry::make('repetitions')
                                            ->label('Repetições')
                                            ->badge()
                                            ->color('info')
                                            ->placeholder('-'),

                                        TextEntry::make('rest_seconds')
                                            ->label('Descanso')
                                            ->badge()
                                            ->color('warning')
                                            ->formatStateUsing(fn ($state): string => filled($state) ? "{$state}s" : '-')
                                            ->placeholder('-'),

                                        TextEntry::make('load')
                                            ->label('Carga')
                                            ->badge()
                                            ->color('success')
                                            ->formatStateUsing(fn ($state): string => filled($state) ? number_format((float) $state, 2, ',', '.').' kg' : '-')
                                            ->placeholder('-'),

                                        TextEntry::make('observation')
                                            ->label('Observações')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->contained(true),
                    ]),

                Section::make('Histórico de Treinos')
                    ->description('Treinos executados com os exercícios registrados em cada sessão.')
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes(['id' => 'section-historico-treinos'])
                    ->schema([
                        RepeatableEntry::make('workout_logs_snapshot')
                            ->label('Sessões Realizadas')
                            ->state(function (TrainingSheet $record): array {
                                return $record->workoutLogs()
                                    ->with(['sheetDivision.trainingDivision', 'validator', 'logExercises.exercise'])
                                    ->orderByDesc('started_at')
                                    ->get()
                                    ->map(function ($log): array {
                                        return [
                                            'started_at' => $log->started_at,
                                            'finished_at' => $log->finished_at,
                                            'duration_minutes' => $log->duration_minutes,
                                            'division_name' => $log->sheetDivision?->trainingDivision?->name,
                                            'validator_name' => $log->validator?->name,
                                            'exercise_total' => $log->logExercises->count(),
                                            'log_exercises' => $log->logExercises
                                                ->map(fn ($exercise): array => [
                                                    'exercise_name' => $exercise->exercise?->name ?? '-',
                                                    'performed_series' => $exercise->performed_series,
                                                    'performed_repetitions' => $exercise->performed_repetitions,
                                                    'performed_load' => $exercise->performed_load,
                                                    'completed' => $exercise->completed,
                                                    'observation' => $exercise->observation,
                                                ])
                                                ->all(),
                                        ];
                                    })
                                    ->all();
                            })
                            ->schema([
                                TextEntry::make('started_at')
                                    ->label('Início')
                                    ->dateTime('d/m/Y H:i')
                                    ->placeholder('-'),

                                TextEntry::make('finished_at')
                                    ->label('Fim')
                                    ->dateTime('d/m/Y H:i')
                                    ->placeholder('-'),

                                TextEntry::make('duration_minutes')
                                    ->label('Duração')
                                    ->formatStateUsing(fn ($state): string => filled($state) ? "{$state} min" : '-')
                                    ->placeholder('-'),

                                TextEntry::make('division_name')
                                    ->label('Divisão')
                                    ->formatStateUsing(fn ($state): string => filled($state) ? 'Treino '.$state : '-')
                                    ->placeholder('-'),

                                TextEntry::make('validator_name')
                                    ->label('Validado por')
                                    ->placeholder('-'),

                                TextEntry::make('exercise_total')
                                    ->label('Qtd. Exercícios')
                                    ->badge(),

                                RepeatableEntry::make('log_exercises')
                                    ->label('Exercícios Executados')
                                    ->contained(true)
                                    ->columns(6)
                                    ->extraAttributes(['class' => 'divide-y divide-gray-100 dark:divide-gray-700'])
                                    ->schema([
                                        TextEntry::make('exercise_name')
                                            ->label('Exercício')
                                            ->weight('medium')
                                            ->columnSpan(2),

                                        TextEntry::make('performed_series')
                                            ->label('Séries')
                                            ->badge()
                                            ->color('info')
                                            ->placeholder('-'),

                                        TextEntry::make('performed_repetitions')
                                            ->label('Repetições')
                                            ->badge()
                                            ->color('info')
                                            ->placeholder('-'),

                                        TextEntry::make('performed_load')
                                            ->label('Carga')
                                            ->badge()
                                            ->color('success')
                                            ->formatStateUsing(fn ($state): string => filled($state) ? number_format((float) $state, 2, ',', '.').' kg' : '-')
                                            ->placeholder('-'),

                                        IconEntry::make('completed')
                                            ->label('Concluído')
                                            ->boolean(),

                                        TextEntry::make('observation')
                                            ->label('Observações')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->columns(3),
                    ]),
            ]);
    }
}
