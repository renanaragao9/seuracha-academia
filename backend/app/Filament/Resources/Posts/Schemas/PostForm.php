<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\PostType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informações da Postagem')
                    ->columns(2)
                    ->schema([
                        Select::make('post_type_id')
                            ->label('Tipo de Postagem')
                            ->options(PostType::where('is_active', true)->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Rascunho',
                                'published' => 'Publicado',
                                'archived' => 'Arquivado',
                            ])
                            ->default('draft')
                            ->required(),

                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        RichEditor::make('description')
                            ->label('Descrição')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Mídia e Links')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Imagem')
                            ->image()
                            ->disk('public')
                            ->directory('posts/images')
                            ->nullable(),

                        TextInput::make('link_video')
                            ->label('Link do Vídeo')
                            ->url()
                            ->placeholder('https://youtube.com/...')
                            ->nullable(),

                        TextInput::make('link_site')
                            ->label('Link do Site')
                            ->url()
                            ->placeholder('https://...')
                            ->nullable(),
                    ]),

                Section::make('Período de Exibição')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Data de Início')
                            ->displayFormat('d/m/Y')
                            ->nullable(),

                        DatePicker::make('end_date')
                            ->label('Data de Fim')
                            ->displayFormat('d/m/Y')
                            ->nullable(),
                    ]),
            ]);
    }
}
