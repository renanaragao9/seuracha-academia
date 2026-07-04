<?php

namespace App\Filament\Resources\WorkoutLogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WorkoutLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('Aluno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('trainingSheet.name')
                    ->label('Ficha')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sheetDivision.trainingDivision.name')
                    ->label('Divisão')
                    ->formatStateUsing(fn ($state): string => filled($state) ? 'Treino '.$state : '-')
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->label('Duração')
                    ->numeric()
                    ->suffix(' min')
                    ->placeholder('-')
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
                TextColumn::make('validator.name')
                    ->label('Validado por')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('student_id')
                    ->label('Aluno')
                    ->relationship('student', 'name')
                    ->searchable(),
                SelectFilter::make('training_sheet_id')
                    ->label('Ficha')
                    ->relationship('trainingSheet', 'name')
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make(),
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
