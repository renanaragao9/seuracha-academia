<?php

namespace App\Filament\Resources\Exercises\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExerciseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações Gerais')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome'),

                        TextEntry::make('is_active')
                            ->label('Ativo')
                            ->badge()
                            ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não'),

                        TextEntry::make('muscleGroup.name')
                            ->label('Grupo Muscular'),

                        TextEntry::make('equipmentType.name')
                            ->label('Tipo de Equipamento'),

                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('description')
                            ->label('Descrição')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Mídia')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('image_path')
                            ->label('Imagem')
                            ->placeholder('-'),

                        ImageEntry::make('gif_path')
                            ->label('GIF')
                            ->placeholder('-'),

                        TextEntry::make('video_path')
                            ->label('URL do Vídeo')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
