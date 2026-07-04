<?php

namespace App\Filament\Resources\TrainingSheets\Schemas;

use App\Models\EquipmentType;
use App\Models\MuscleGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class TrainingSheetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados da Ficha')
                    ->columns(2)
                    ->schema([
                        Select::make('student_id')
                            ->label('Aluno')
                            ->relationship(
                                name: 'student',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query): Builder => $query
                                    ->where('is_active', true)
                                    ->orderBy('name')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('name')
                            ->label('Nome da Ficha')
                            ->placeholder('Ex.: Ficha Junho/2026')
                            ->required()
                            ->maxLength(255),

                        DatePicker::make('start_date')
                            ->label('Início')
                            ->displayFormat('d/m/Y')
                            ->nullable(),

                        DatePicker::make('end_date')
                            ->label('Fim')
                            ->displayFormat('d/m/Y')
                            ->nullable(),

                        Toggle::make('is_active')
                            ->label('Ficha ativa')
                            ->default(true)
                            ->columnSpanFull(),
                    ]),

                Section::make('Divisões e Exercícios')
                    ->description('Adicione as divisões (A, B, C...) e inclua os exercícios em cada uma delas.')
                    ->schema([
                        Repeater::make('divisions')
                            ->label('Divisões')
                            ->relationship()
                            ->orderColumn('order')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->collapsed(false)
                            ->cloneable()
                            ->defaultItems(0)
                            ->addActionLabel('Adicionar divisão')
                            ->schema([
                                Select::make('training_division_id')
                                    ->label('Divisão de treino')
                                    ->relationship(
                                        name: 'trainingDivision',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn (Builder $query): Builder => $query
                                            ->where('is_active', true)
                                            ->orderBy('name')
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Repeater::make('exercises')
                                    ->label('Exercícios')
                                    ->relationship()
                                    ->orderColumn('order')
                                    ->reorderableWithButtons()
                                    ->collapsible()
                                    ->collapsed(false)
                                    ->cloneable()
                                    ->defaultItems(0)
                                    ->addActionLabel('Adicionar exercício')
                                    ->columns(4)
                                    ->schema([
                                        Select::make('muscle_group_filter')
                                            ->label('Grupo Muscular')
                                            ->options(
                                                fn () => MuscleGroup::where('is_active', true)
                                                    ->orderBy('name')
                                                    ->pluck('name', 'id')
                                            )
                                            ->placeholder('Todos os grupos')
                                            ->live()
                                            ->dehydrated(false)
                                            ->columnSpan(2),

                                        Select::make('equipment_type_filter')
                                            ->label('Equipamento')
                                            ->options(
                                                fn () => EquipmentType::where('is_active', true)
                                                    ->orderBy('name')
                                                    ->pluck('name', 'id')
                                            )
                                            ->placeholder('Todos os equipamentos')
                                            ->live()
                                            ->dehydrated(false)
                                            ->columnSpan(2),

                                        Select::make('exercise_id')
                                            ->label('Exercício')
                                            ->relationship(
                                                name: 'exercise',
                                                titleAttribute: 'name',
                                                modifyQueryUsing: fn (Builder $query, $get): Builder => $query
                                                    ->where('is_active', true)
                                                    ->when(
                                                        $get('muscle_group_filter'),
                                                        fn (Builder $q, $value) => $q->where('muscle_group_id', $value),
                                                    )
                                                    ->when(
                                                        $get('equipment_type_filter'),
                                                        fn (Builder $q, $value) => $q->where('equipment_type_id', $value),
                                                    )
                                                    ->orderBy('name')
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->required()
                                            ->columnSpan(2),

                                        TextInput::make('series')
                                            ->label('Séries')
                                            ->numeric()
                                            ->minValue(1)
                                            ->default(3)
                                            ->required(),

                                        TextInput::make('repetitions')
                                            ->label('Repetições')
                                            ->placeholder('10 ou 8-12')
                                            ->default('10')
                                            ->required(),

                                        TextInput::make('rest_seconds')
                                            ->label('Descanso')
                                            ->numeric()
                                            ->minValue(0)
                                            ->default(30)
                                            ->suffix('seg'),

                                        TextInput::make('load')
                                            ->label('Carga')
                                            ->numeric()
                                            ->step(0.01)
                                            ->default(5)
                                            ->suffix('kg'),

                                        Textarea::make('observation')
                                            ->label('Observações')
                                            ->rows(2)
                                            ->columnSpanFull()
                                            ->nullable(),
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
