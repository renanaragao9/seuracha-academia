<?php

namespace App\Filament\Resources\Foods\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class FoodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados do Alimento')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('food_type_id')
                            ->label('Tipo de Alimento')
                            ->relationship(
                                name: 'foodType',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->where('is_active', true)
                                    ->orderBy('name'),
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('link_url')
                            ->label('Link')
                            ->url()
                            ->nullable()
                            ->maxLength(255),

                        FileUpload::make('image_path')
                            ->label('Imagem')
                            ->image()
                            ->disk('public')
                            ->directory('foods/images')
                            ->nullable()
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
