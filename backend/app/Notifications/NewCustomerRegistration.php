<?php

namespace App\Notifications;

use App\Models\CustomerRegistration;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Notifications\Notification;

class NewCustomerRegistration extends Notification
{
    public function __construct(
        public CustomerRegistration $customerRegistration,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return FilamentNotification::make()
            ->title('Novo Pré-Cadastro Recebido')
            ->body('Um novo cliente iniciou o pré-cadastro: '.$this->customerRegistration->name)
            ->icon('heroicon-o-user-plus')
            ->getDatabaseMessage();
    }
}
