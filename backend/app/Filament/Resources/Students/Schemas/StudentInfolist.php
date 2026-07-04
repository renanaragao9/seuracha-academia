<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Models\Student;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados Pessoais')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('image_path')
                            ->label('Foto')
                            ->circular()
                            ->placeholder('-')
                            ->columnSpanFull(),

                        TextEntry::make('name')
                            ->label('Nome'),

                        TextEntry::make('code')
                            ->label('Código'),

                        TextEntry::make('email')
                            ->label('E-mail')
                            ->placeholder('-'),

                        TextEntry::make('phone')
                            ->label('Telefone')
                            ->placeholder('-'),

                        TextEntry::make('gender')
                            ->label('Sexo')
                            ->formatStateUsing(fn ($state) => Student::GENDERS[$state] ?? '-')
                            ->placeholder('-'),

                        TextEntry::make('color')
                            ->label('Cor / Etnia')
                            ->placeholder('-'),

                        TextEntry::make('birth_date')
                            ->label('Data de Nascimento')
                            ->date('d/m/Y')
                            ->placeholder('-'),

                        TextEntry::make('entry_date')
                            ->label('Data de Entrada')
                            ->date('d/m/Y')
                            ->placeholder('-'),

                        TextEntry::make('responsible.name')
                            ->label('Instrutor / Responsável')
                            ->placeholder('-'),

                        TextEntry::make('last_access_at')
                            ->label('Último Acesso')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-'),
                    ]),

                Section::make('Dados Físicos')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('weight')
                            ->label('Peso')
                            ->suffix(' kg')
                            ->placeholder('-'),

                        TextEntry::make('height')
                            ->label('Altura')
                            ->suffix(' cm')
                            ->placeholder('-'),
                    ]),

                Section::make('Status e Auditoria')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'active' => 'success',
                                'inactive' => 'gray',
                                'suspended' => 'danger',
                                'pending' => 'warning',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn ($state) => Student::STATUSES[$state] ?? $state),

                        IconEntry::make('is_active')
                            ->label('Ativo')
                            ->boolean(),

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
