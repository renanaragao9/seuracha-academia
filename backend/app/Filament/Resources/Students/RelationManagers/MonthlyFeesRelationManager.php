<?php

namespace App\Filament\Resources\Students\RelationManagers;

use App\Filament\Actions\DownloadMonthlyFeeReceiptAction;
use App\Filament\Resources\MonthlyFees\MonthlyFeeResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MonthlyFeesRelationManager extends RelationManager
{
    protected static string $relationship = 'monthlyFees';

    protected static ?string $relatedResource = MonthlyFeeResource::class;

    protected static ?string $title = 'Mensalidades';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('planType.name')
                    ->label('Plano')
                    ->sortable(),

                TextColumn::make('paymentType.name')
                    ->label('Forma de Pagamento'),

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
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->headerActions([
                Action::make('createMonthlyFee')
                    ->label('Nova Mensalidade')
                    ->color('primary')
                    ->url(fn () => MonthlyFeeResource::getUrl('create', [
                        'student_id' => $this->getOwnerRecord()->getKey(),
                    ])),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),

                DownloadMonthlyFeeReceiptAction::make(),

            ]);
    }
}
