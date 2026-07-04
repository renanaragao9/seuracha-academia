<?php

namespace App\Filament\Resources\WorkoutLogs\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LogExercisesRelationManager extends RelationManager
{
    protected static string $relationship = 'logExercises';

    protected static ?string $title = 'Exercícios Executados';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('performed_repetitions')
                    ->label('Repetições executadas'),
                Textarea::make('observation')
                    ->label('Observações')
                    ->columnSpanFull(),
                TextInput::make('performed_load')
                    ->label('Carga executada')
                    ->numeric()
                    ->suffix('kg'),
                TextInput::make('performed_series')
                    ->label('Séries executadas')
                    ->numeric(),
                Toggle::make('completed')
                    ->label('Concluído')
                    ->required(),
                Select::make('exercise_id')
                    ->label('Exercício')
                    ->relationship('exercise', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('exercise_id')
            ->columns([
                TextColumn::make('exercise.name')
                    ->label('Exercício')
                    ->searchable(),
                TextColumn::make('performed_repetitions')
                    ->label('Repetições')
                    ->searchable(),
                TextColumn::make('performed_load')
                    ->label('Carga')
                    ->numeric()
                    ->suffix(' kg')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('performed_series')
                    ->label('Séries')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                IconColumn::make('completed')
                    ->label('Concluído')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
