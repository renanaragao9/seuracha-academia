<?php

namespace App\Filament\Resources\Students\RelationManagers;

use App\Filament\Actions\DownloadMealPlanPdfAction;
use App\Filament\Resources\MealPlans\MealPlanResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MealPlansRelationManager extends RelationManager
{
    protected static string $relationship = 'mealPlans';

    protected static ?string $relatedResource = MealPlanResource::class;

    protected static ?string $title = 'Planos Alimentares';

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true))
            ->columns([
                TextColumn::make('name')
                    ->label('Plano')
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
                    ->label('Ativo')
                    ->boolean(),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->headerActions([
                Action::make('createMealPlan')
                    ->label('Novo Plano Alimentar')
                    ->color('primary')
                    ->url(fn () => MealPlanResource::getUrl('create', [
                        'student_id' => $this->getOwnerRecord()->getKey(),
                    ])),
            ])
            ->recordActions([
                ViewAction::make(),
                DownloadMealPlanPdfAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
