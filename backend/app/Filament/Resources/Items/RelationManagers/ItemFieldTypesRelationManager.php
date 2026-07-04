<?php

namespace App\Filament\Resources\Items\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ItemFieldTypesRelationManager extends RelationManager
{
    protected static string $relationship = 'itemFieldTypes';

    protected static ?string $title = 'Campos do Item';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('field_type_id')
                    ->label('Tipo de Campo')
                    ->relationship(
                        name: 'fieldType',
                        titleAttribute: 'name',
                        modifyQueryUsing: function (Builder $query, ?Component $component = null) {
                            $record = $component?->getRecord();
                            $excludeIds = $this->getOwnerRecord()->itemFieldTypes()
                                ->when($record, fn ($q) => $q->where('id', '!=', $record->id))
                                ->pluck('field_type_id');

                            return $query->whereNotIn('id', $excludeIds);
                        },
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('value')
                    ->label('Valor')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fieldType.name')
                    ->label('Tipo de Campo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('value')
                    ->label('Valor')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Adicionado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Editar Campo'),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Adicionar Campo'),
            ]);
    }
}
