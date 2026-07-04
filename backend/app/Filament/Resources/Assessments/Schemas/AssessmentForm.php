<?php

namespace App\Filament\Resources\Assessments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class AssessmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados da Avaliação')
                    ->columns(2)
                    ->schema([
                        Select::make('student_id')
                            ->label('Aluno')
                            ->relationship(
                                name: 'student',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query): Builder => $query
                                    ->where('is_active', true)
                                    ->orderBy('name'),
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('name')
                            ->label('Nome da Avaliação')
                            ->placeholder('Ex.: Avaliação Junho/2026')
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
                            ->label('Avaliação ativa')
                            ->default(true)
                            ->columnSpanFull(),

                        Textarea::make('observations')
                            ->label('Observações')
                            ->rows(3)
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Medições')
                    ->description('Adicione as medições realizadas nesta avaliação.')
                    ->schema([
                        Repeater::make('items')
                            ->label('Itens da Avaliação')
                            ->relationship()
                            ->orderColumn('order')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->collapsed(false)
                            ->cloneable()
                            ->defaultItems(0)
                            ->addActionLabel('Adicionar medição')
                            ->columns(4)
                            ->schema([
                                Select::make('measurement_type_id')
                                    ->label('Tipo de Medição')
                                    ->relationship(
                                        name: 'measurementType',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn (Builder $query): Builder => $query
                                            ->where('is_active', true)
                                            ->orderBy('name'),
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->required()
                                    ->columnSpan(2),

                                TextInput::make('value')
                                    ->label('Valor')
                                    ->numeric()
                                    ->step(0.01)
                                    ->required(),

                                TextInput::make('unit')
                                    ->label('Unidade')
                                    ->placeholder('cm, kg, %...')
                                    ->nullable(),

                                Textarea::make('notes')
                                    ->label('Observações')
                                    ->rows(2)
                                    ->columnSpanFull()
                                    ->nullable(),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
