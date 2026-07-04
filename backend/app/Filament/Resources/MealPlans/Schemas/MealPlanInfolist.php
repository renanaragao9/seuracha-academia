<?php

namespace App\Filament\Resources\MealPlans\Schemas;

use App\Models\MealPlan;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MealPlanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados do Plano')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Plano'),

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
                            ->label('Ativo')
                            ->boolean(),

                        TextEntry::make('meals_total')
                            ->label('Total de Refeições')
                            ->state(fn (MealPlan $record): int => $record->meals()->count()),
                    ]),

                Section::make('Auditoria')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('creator.name')
                            ->label('Criado por')
                            ->placeholder('-'),

                        TextEntry::make('updater.name')
                            ->label('Atualizado por')
                            ->placeholder('-'),

                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i'),
                    ]),

                Section::make('Refeições e Alimentos')
                    ->description('Visualização completa do plano com as refeições e alimentos.')
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        RepeatableEntry::make('meals_snapshot')
                            ->label('Refeições')
                            ->columns(2)
                            ->state(function (MealPlan $record): array {
                                return $record->meals()
                                    ->with(['mealType', 'foods.food'])
                                    ->orderBy('order')
                                    ->get()
                                    ->map(fn ($meal): array => [
                                        'meal_name' => $meal->mealType?->name ?? '-',
                                        'foods_total' => $meal->foods->count(),
                                        'foods' => $meal->foods
                                            ->sortBy('order')
                                            ->values()
                                            ->map(fn ($item): array => [
                                                'food_name' => $item->food?->name ?? '-',
                                                'quantity' => $item->quantity,
                                                'unit' => $item->unit,
                                                'observation' => $item->observation,
                                            ])
                                            ->all(),
                                    ])
                                    ->all();
                            })
                            ->schema([
                                TextEntry::make('meal_name')
                                    ->label('Refeição')
                                    ->weight('bold'),

                                TextEntry::make('foods_total')
                                    ->label('Alimentos')
                                    ->badge(),

                                RepeatableEntry::make('foods')
                                    ->label('Alimentos')
                                    ->contained(true)
                                    ->columns(4)
                                    ->schema([
                                        TextEntry::make('food_name')
                                            ->label('Alimento')
                                            ->columnSpan(2),

                                        TextEntry::make('quantity')
                                            ->label('Quantidade')
                                            ->badge()
                                            ->placeholder('-'),

                                        TextEntry::make('unit')
                                            ->label('Unidade')
                                            ->badge()
                                            ->color('gray')
                                            ->placeholder('-'),

                                        TextEntry::make('observation')
                                            ->label('Observações')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
