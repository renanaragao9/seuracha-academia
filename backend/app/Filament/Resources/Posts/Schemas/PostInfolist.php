<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Post;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informações da Postagem')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('title')
                            ->label('Título'),

                        TextEntry::make('postType.name')
                            ->label('Tipo de Postagem'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'published' => 'success',
                                'draft' => 'warning',
                                'archived' => 'gray',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'published' => 'Publicado',
                                'draft' => 'Rascunho',
                                'archived' => 'Arquivado',
                                default => $state,
                            }),

                        TextEntry::make('description')
                            ->label('Descrição')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Section::make('Mídia e Links')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        ImageEntry::make('image_path')
                            ->label('Imagem')
                            ->disk('public')
                            ->placeholder('-'),

                        TextEntry::make('link_video')
                            ->label('Link do Vídeo')
                            ->placeholder('-'),

                        TextEntry::make('link_site')
                            ->label('Link do Site')
                            ->placeholder('-'),
                    ]),

                Section::make('Período de Exibição')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('start_date')
                            ->label('Data de Início')
                            ->date('d/m/Y')
                            ->placeholder('-'),

                        TextEntry::make('end_date')
                            ->label('Data de Fim')
                            ->date('d/m/Y')
                            ->placeholder('-'),
                    ]),

                Section::make('Auditoria')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Autor'),

                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('deleted_at')
                            ->label('Excluído em')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-')
                            ->visible(fn (Post $record): bool => $record->trashed()),
                    ]),
            ]);
    }
}
