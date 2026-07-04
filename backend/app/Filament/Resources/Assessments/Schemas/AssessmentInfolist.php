<?php

namespace App\Filament\Resources\Assessments\Schemas;

use App\Models\Assessment;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AssessmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados da Avaliação')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Avaliação'),

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

                        TextEntry::make('items_total')
                            ->label('Total de Medições')
                            ->state(fn (Assessment $record): int => $record->items()->count()),

                        TextEntry::make('observations')
                            ->label('Observações')
                            ->placeholder('-')
                            ->columnSpanFull(),
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

                Section::make('Medições')
                    ->description('Medições realizadas nesta avaliação.')
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        RepeatableEntry::make('items_snapshot')
                            ->label('Medições')
                            ->grid(2)
                            ->columns(2)
                            ->state(function (Assessment $record): array {
                                return $record->items()
                                    ->with('measurementType')
                                    ->orderBy('order')
                                    ->get()
                                    ->map(fn ($item): array => [
                                        'measurement_type' => $item->measurementType?->name ?? '-',
                                        'value' => $item->value,
                                        'unit' => $item->unit,
                                        'notes' => $item->notes,
                                    ])
                                    ->all();
                            })
                            ->schema([
                                TextEntry::make('measurement_type')
                                    ->label('Tipo')
                                    ->weight('bold')
                                    ->columnSpan(2),

                                TextEntry::make('value')
                                    ->label('Valor')
                                    ->numeric()
                                    ->badge()
                                    ->placeholder('-'),

                                TextEntry::make('unit')
                                    ->label('Unidade')
                                    ->badge()
                                    ->color('gray')
                                    ->placeholder('-'),

                                TextEntry::make('notes')
                                    ->label('Observações')
                                    ->placeholder('-')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
