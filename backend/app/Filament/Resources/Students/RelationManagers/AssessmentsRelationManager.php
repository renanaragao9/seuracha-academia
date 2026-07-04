<?php

namespace App\Filament\Resources\Students\RelationManagers;

use App\Filament\Actions\DownloadAssessmentPdfAction;
use App\Filament\Resources\Assessments\AssessmentResource;
use App\Models\Assessment;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssessmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assessments';

    protected static ?string $relatedResource = AssessmentResource::class;

    protected static ?string $title = 'Avaliações';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Avaliação')
                    ->searchable()
                    ->sortable(),

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
                    ->label('Ativo')
                    ->boolean(),

                TextColumn::make('items_total')
                    ->label('Medições')
                    ->state(fn (Assessment $record): int => $record->items()->count()),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->headerActions([
                Action::make('createAssessment')
                    ->label('Nova Avaliação')
                    ->color('primary')
                    ->url(fn () => AssessmentResource::getUrl('create', [
                        'student_id' => $this->getOwnerRecord()->getKey(),
                    ])),
            ])
            ->recordActions([
                ViewAction::make(),
                DownloadAssessmentPdfAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
