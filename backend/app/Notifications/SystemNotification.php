<?php

namespace App\Notifications;

use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    protected string $title;

    protected string $body;

    protected ?string $icon;

    protected ?string $url;

    public function __construct(string $title, string $body, ?string $icon = null, ?string $url = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->icon = $icon;
        $this->url = $url;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return FilamentNotification::make()
            ->title($this->title)
            ->body($this->body)
            ->icon($this->icon ?? 'heroicon-o-bell')
            ->url($this->url)
            ->getDatabaseMessage();
    }
}
