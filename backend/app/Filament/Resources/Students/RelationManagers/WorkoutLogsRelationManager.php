<?php

namespace App\Filament\Resources\Students\RelationManagers;

use App\Filament\Resources\WorkoutLogs\WorkoutLogResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WorkoutLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'workoutLogs';

    protected static ?string $title = 'Registros de Treino';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('training_sheet_id')
                    ->label('Ficha')
                    ->relationship(
                        name: 'trainingSheet',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query): Builder => $query
                            ->where('student_id', $this->getOwnerRecord()->getKey())
                            ->orderBy('name')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('training_sheet_division_id')
                    ->label('Divisão da Ficha')
                    ->relationship(
                        name: 'sheetDivision',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn (Builder $query): Builder => $query
                            ->with(['trainingDivision', 'trainingSheet'])
                            ->whereHas('trainingSheet', fn (Builder $sheetQuery): Builder => $sheetQuery
                                ->where('student_id', $this->getOwnerRecord()->getKey())
                            )
                            ->orderBy('training_sheet_id')
                            ->orderBy('order')
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record): string => 'Treino '.($record->trainingDivision?->name ?? '-').' - '.($record->trainingSheet?->name ?? 'Ficha'))
                    ->searchable()
                    ->preload()
                    ->required(),

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

                Select::make('validated_by')
                    ->label('Validado por')
                    ->relationship('validator', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trainingSheet.name')
                    ->label('Ficha')
                    ->searchable(),
                TextColumn::make('sheetDivision.trainingDivision.name')
                    ->label('Divisão')
                    ->formatStateUsing(fn ($state): string => filled($state) ? 'Treino '.$state : '-')
                    ->sortable(),
                TextColumn::make('started_at')
                    ->label('Início')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('finished_at')
                    ->label('Fim')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->label('Duração')
                    ->suffix(' min')
                    ->placeholder('-')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->label('Adicionar Registro de Treino'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn ($record) => WorkoutLogResource::getUrl('view', ['record' => $record])),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
