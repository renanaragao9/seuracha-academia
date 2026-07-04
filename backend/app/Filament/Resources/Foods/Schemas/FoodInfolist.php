<?php

namespace App\Filament\Resources\Foods\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FoodInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados do Alimento')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('image_path')
                            ->label('Imagem')
                            ->placeholder('-')
                            ->columnSpanFull(),

                        TextEntry::make('name')
                            ->label('Nome'),

                        TextEntry::make('foodType.name')
                            ->label('Tipo de Alimento'),

                        TextEntry::make('link_url')
                            ->label('Link')
                            ->placeholder('-'),

                        IconEntry::make('is_active')
                            ->label('Ativo')
                            ->boolean(),
                    ]),

                Section::make('Auditoria')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i'),
                    ]),
            ]);
    }
}
