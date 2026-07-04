<?php

namespace App\Filament\Resources\Exercises\Schemas;

use App\Models\EquipmentType;
use App\Models\MuscleGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExerciseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informações Gerais')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('muscle_group_id')
                            ->label('Grupo Muscular')
                            ->options(MuscleGroup::where('is_active', true)->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Select::make('equipment_type_id')
                            ->label('Tipo de Equipamento')
                            ->options(EquipmentType::where('is_active', true)->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Textarea::make('description')
                            ->label('Descrição')
                            ->rows(4)
                            ->nullable()
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),
                    ]),

                Section::make('Mídia')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Imagem')
                            ->image()
                            ->disk('public')
                            ->directory('exercises/images')
                            ->nullable(),

                        FileUpload::make('gif_path')
                            ->label('GIF')
                            ->acceptedFileTypes(['image/gif'])
                            ->disk('public')
                            ->directory('exercises/gifs')
                            ->nullable(),

                        TextInput::make('video_path')
                            ->label('URL do Vídeo')
                            ->url()
                            ->placeholder('https://youtube.com/...')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
