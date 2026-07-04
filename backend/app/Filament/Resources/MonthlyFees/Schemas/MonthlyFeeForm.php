<?php

namespace App\Filament\Resources\MonthlyFees\Schemas;

use App\Models\PlanType;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class MonthlyFeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dados da Mensalidade')
                    ->columns(2)
                    ->schema([
                        Select::make('student_id')
                            ->label('Aluno')
                            ->relationship(
                                name: 'student',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query): Builder => $query
                                    ->where('is_active', true)
                                    ->orderBy('name'),
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),

                        Select::make('plan_type_id')
                            ->label('Plano')
                            ->relationship(
                                name: 'planType',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query): Builder => $query
                                    ->where('is_active', true)
                                    ->orderBy('name'),
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set, ?int $state): void {
                                if (! $state) {
                                    return;
                                }

                                $plan = PlanType::find($state);

                                if (! $plan) {
                                    return;
                                }

                                if ($plan->amount_base !== null) {
                                    $full = number_format((float) $plan->amount_base, 2, '.', '');
                                    $set('full_payment', $full);
                                    $set('amount_paid', $full);
                                }

                                if ($plan->period_days) {
                                    $start = $get('start_date');
                                    $startDate = $start ? Carbon::parse($start) : now();

                                    if (! $start) {
                                        $set('start_date', $startDate->toDateString());
                                    }

                                    $set('end_date', $startDate->copy()->addDays($plan->period_days - 1)->toDateString());
                                }
                            }),

                        Select::make('payment_type_id')
                            ->label('Forma de Pagamento')
                            ->relationship(
                                name: 'paymentType',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query): Builder => $query
                                    ->where('is_active', true)
                                    ->orderBy('name'),
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pendente',
                                'paid' => 'Pago',
                                'overdue' => 'Vencido',
                                'cancelled' => 'Cancelado',
                                'refunded' => 'Reembolsado',
                            ])
                            ->default('pending')
                            ->required(),

                        DatePicker::make('start_date')
                            ->label('Início da Vigência')
                            ->displayFormat('d/m/Y')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state): void {
                                if (! $state) {
                                    return;
                                }

                                $plan = PlanType::find($get('plan_type_id'));

                                if (! $plan?->period_days) {
                                    return;
                                }

                                $set('end_date', Carbon::parse($state)->addDays($plan->period_days - 1)->toDateString());
                            }),

                        DatePicker::make('end_date')
                            ->label('Fim da Vigência')
                            ->displayFormat('d/m/Y')
                            ->required(),

                        DatePicker::make('date_payment')
                            ->label('Data do Pagamento')
                            ->displayFormat('d/m/Y')
                            ->nullable(),

                        TextInput::make('discount_payment')
                            ->label('Desconto (R$)')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('R$')
                            ->default(null)
                            ->placeholder('-')
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state): void {
                                $full = (float) ($get('full_payment') ?? 0);
                                $discount = (float) ($state ?? 0);

                                $set('amount_paid', number_format(max(0, $full - $discount), 2, '.', ''));
                            }),

                        TextInput::make('full_payment')
                            ->label('Valor do Plano (R$)')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('R$')
                            ->required(),

                        TextInput::make('amount_paid')
                            ->label('Valor Pago (R$)')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('R$')
                            ->nullable(),
                    ]),
            ]);
    }
}
