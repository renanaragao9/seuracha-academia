<?php

namespace App\Filament\Resources\Items\Schemas;

use App\Models\Item;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ItemInfolist
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

                        TextEntry::make('itemType.name')
                            ->label('Tipo de Item'),

                        TextEntry::make('total_price')
                            ->label('Preço Total')
                            ->money('BRL'),

                        TextEntry::make('promotion_price')
                            ->label('Preço de Promoção')
                            ->money('BRL')
                            ->placeholder('-'),

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
                            ->visible(fn (Item $record): bool => $record->trashed()),

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
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
