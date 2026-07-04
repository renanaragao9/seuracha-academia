<?php

namespace App\Helpers;

use App\Models\User;
use Filament\Notifications\Notification;

class NotificationHelper
{
    public static function notify(User $user, string $title, string $body, string $icon = 'heroicon-o-information-circle'): void
    {
        $user->notify(
            Notification::make()
                ->title($title)
                ->body($body)
                ->icon($icon)
                ->toDatabase()
        );
    }

    public static function notifyMultiple(array $users, string $title, string $body, string $icon = 'heroicon-o-information-circle'): void
    {
        foreach ($users as $user) {
            static::notify($user, $title, $body, $icon);
        }
    }

    public static function notifyAll(string $title, string $body, string $icon = 'heroicon-o-information-circle'): void
    {
        $users = User::all();
        static::notifyMultiple($users->toArray(), $title, $body, $icon);
    }

    public static function notifySuccess(User $user, string $title, string $body): void
    {
        static::notify($user, $title, $body, 'heroicon-o-check-circle');
    }

    public static function notifyError(User $user, string $title, string $body): void
    {
        static::notify($user, $title, $body, 'heroicon-o-exclamation-circle');
    }

    public static function notifyWarning(User $user, string $title, string $body): void
    {
        static::notify($user, $title, $body, 'heroicon-o-exclamation-triangle');
    }

    public static function notifyInfo(User $user, string $title, string $body): void
    {
        static::notify($user, $title, $body, 'heroicon-o-information-circle');
    }
}
