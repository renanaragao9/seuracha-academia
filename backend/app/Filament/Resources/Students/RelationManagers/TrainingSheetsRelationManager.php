<?php

namespace App\Filament\Resources\Students\RelationManagers;

use App\Filament\Actions\DownloadTrainingSheetPdfAction;
use App\Filament\Resources\TrainingSheets\TrainingSheetResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TrainingSheetsRelationManager extends RelationManager
{
    protected static string $relationship = 'trainingSheets';

    protected static ?string $relatedResource = TrainingSheetResource::class;

    protected static ?string $title = 'Fichas de Treino';

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true))
            ->columns([
                TextColumn::make('name')
                    ->label('Ficha')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Início')
                    ->date('d/m/Y')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Fim')
                    ->date('d/m/Y')
                    ->placeholder('-')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Ativa')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->headerActions([
                Action::make('createTrainingSheet')
                    ->label('Nova Ficha de Treino')
                    ->color('primary')
                    ->url(fn () => TrainingSheetResource::getUrl('create', [
                        'student_id' => $this->getOwnerRecord()->getKey(),
                    ])),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),

                DownloadTrainingSheetPdfAction::make(),
            ]);
    }
}
