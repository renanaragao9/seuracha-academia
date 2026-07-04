<?php

namespace App\Notifications\Student;

use App\Models\Configuration;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentWellcome extends Notification implements ShouldQueue
{
    use Queueable;

    protected Student $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $student = $this->student;
        $appName = Configuration::first()?->name ?? config('app.name');

        $mail = (new MailMessage)
            ->subject("Seja bem-vindo à {$appName}!")
            ->greeting("Olá {$student->name} 👋,")
            ->line("É com grande satisfação que damos as boas-vindas à **{$appName}**! 🏋️")
            ->line('Estamos felizes em tê-lo como parte da nossa família. Prepare-se para transformar seus limites em resultados!')
            ->line('Aqui estão algumas coisas que você pode fazer agora:')
            ->line('- 📋 Acessar e gerenciar suas **fichas de treino**')
            ->line('- 📊 Acompanhar seu **histórico de avaliações físicas**')
            ->line('- 🥗 Consultar seu **plano alimentar** personalizado')
            ->line('- 💳 Visualizar e gerenciar suas **mensalidades**')
            ->action('Acessar Meu Painel', config('app.frontend_url'))
            ->line('Se tiver qualquer dúvida, estamos à disposição.')
            ->salutation("Equipe {$appName}");

        return $mail;
    }
}
