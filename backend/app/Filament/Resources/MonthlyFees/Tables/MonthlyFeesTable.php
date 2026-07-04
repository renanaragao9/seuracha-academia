<?php

namespace App\Filament\Resources\MonthlyFees\Tables;

use App\Filament\Actions\DownloadMonthlyFeeReceiptAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MonthlyFeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('Aluno')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('planType.name')
                    ->label('Plano')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('paymentType.name')
                    ->label('Forma de Pagamento')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->placeholder('-')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'paid' => 'Pago',
                        'pending' => 'Pendente',
                        'overdue' => 'Vencido',
                        'cancelled' => 'Cancelado',
                        'refunded' => 'Reembolsado',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'overdue' => 'danger',
                        'cancelled' => 'gray',
                        'refunded' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Início')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Fim')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('date_payment')
                    ->label('Pagamento')
                    ->date('d/m/Y')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('full_payment')
                    ->label('Valor do Plano')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('discount_payment')
                    ->label('Desconto')
                    ->money('BRL')
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('amount_paid')
                    ->label('Valor Pago')
                    ->money('BRL')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Responsável')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')

            ->filters([
                SelectFilter::make('student_id')
                    ->label('Aluno')
                    ->relationship('student', 'name')
                    ->searchable(),

                SelectFilter::make('plan_type_id')
                    ->label('Plano')
                    ->relationship('planType', 'name')
                    ->searchable(),

                SelectFilter::make('payment_type_id')
                    ->label('Forma de Pagamento')
                    ->relationship('paymentType', 'name')
                    ->searchable(),

                TrashedFilter::make()
                    ->label('Registros excluídos'),
            ])

            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                DownloadMonthlyFeeReceiptAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
