<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Models\Student;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados Pessoais')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Foto')
                            ->image()
                            ->disk('public')
                            ->directory('students/photos')
                            ->avatar()
                            ->nullable()
                            ->columnSpanFull(),

                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->nullable(),

                        TextInput::make('code')
                            ->label('Código')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),

                        TextInput::make('phone')
                            ->label('Telefone')
                            ->mask('(99) 9-9999-9999')
                            ->nullable(),

                        Select::make('gender')
                            ->label('Sexo')
                            ->options(Student::GENDERS)
                            ->nullable(),

                        TextInput::make('color')
                            ->label('Cor / Etnia')
                            ->nullable(),

                        DatePicker::make('birth_date')
                            ->label('Data de Nascimento')
                            ->displayFormat('d/m/Y')
                            ->nullable(),

                        DatePicker::make('entry_date')
                            ->label('Data de Entrada')
                            ->displayFormat('d/m/Y')
                            ->default(now())
                            ->nullable(),

                        Select::make('responsible_id')
                            ->label('Instrutor / Responsável')
                            ->options(fn () => User::whereDoesntHave('role', fn ($q) => $q->where('name', 'Estudante'))->orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Dados Físicos')
                    ->columns(1)
                    ->schema([
                        TextInput::make('weight')
                            ->label('Peso (kg)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('kg')
                            ->nullable(),

                        TextInput::make('height')
                            ->label('Altura (cm)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('cm')
                            ->nullable(),
                    ]),

                Section::make('Status')
                    ->columns(1)
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options(Student::STATUSES)
                            ->default('active')
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Ativo')
                            ->default(true),
                    ]),
            ]);
    }
}
