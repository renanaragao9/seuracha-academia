<?php

namespace App\Filament\Resources\Bookings\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingStudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookingStudents';

    protected static ?string $title = 'Alunos na Reserva';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('student_id')
                    ->label('Aluno')
                    ->relationship(
                        name: 'student',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query
                            ->whereNotIn('id', $this->getOwnerRecord()->bookingStudents()->pluck('student_id')),
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pendente',
                        'confirmed' => 'Confirmado',
                        'cancelled' => 'Cancelado',
                    ])
                    ->default('confirmed')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('Aluno')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('student.email')
                    ->label('Email')
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('student.phone')
                    ->label('Telefone')
                    ->placeholder('-')
                    ->toggleable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pendente',
                        'confirmed' => 'Confirmado',
                        'cancelled' => 'Cancelado',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Adicionado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([
                EditAction::make()
                    ->form(function (Schema $schema) {
                        return $schema
                            ->schema([
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'pending' => 'Pendente',
                                        'confirmed' => 'Confirmado',
                                        'cancelled' => 'Cancelado',
                                    ])
                                    ->required(),
                            ]);
                    }),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Adicionar Aluno'),
            ]);
    }
}
