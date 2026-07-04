<?php

namespace App\Notifications\MonthlyFee;

use App\Models\Configuration;
use App\Models\MonthlyFee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MonthlyFeeCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected MonthlyFee $monthlyFee;

    public function __construct(MonthlyFee $monthlyFee)
    {
        $this->monthlyFee = $monthlyFee;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $fee = $this->monthlyFee;
        $student = $fee->student;
        $planType = $fee->planType;
        $appName = Configuration::first()?->name ?? config('app.name');

        $formatDate = fn ($date) => $date ? $date->format('d/m/Y') : '—';

        $period = $fee->start_date && $fee->end_date
            ? $fee->start_date->format('d/m/Y').' a '.$fee->end_date->format('d/m/Y')
            : '—';

        $mail = (new MailMessage)
            ->subject("Mensalidade registrada - {$appName}")
            ->greeting("Olá {$student->name} 👋,")
            ->line("Sua mensalidade foi registrada com sucesso na **{$appName}**!")
            ->line('Confira os detalhes:')
            ->line("- **Período:** {$period}")
            ->line('- **Valor integral:** R$ '.number_format((float) $fee->full_payment, 2, ',', '.'));

        if ((float) $fee->discount_payment > 0) {
            $mail->line('- **Desconto:** R$ '.number_format((float) $fee->discount_payment, 2, ',', '.'));
        }

        $mail->line('- **Valor pago:** R$ '.number_format((float) $fee->amount_paid, 2, ',', '.'));

        if ($planType) {
            $mail->line("- **Plano:** {$planType->name}");
        }

        $mail->line('- **Data do pagamento:** '.$formatDate($fee->date_payment))
            ->action('Acessar Meu Painel', config('app.frontend_url'))
            ->line('Qualquer dúvida, estamos à disposição.')
            ->salutation("Equipe {$appName}");

        return $mail;
    }
}
