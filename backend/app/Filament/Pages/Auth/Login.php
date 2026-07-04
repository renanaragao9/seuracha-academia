<?php

namespace App\Filament\Pages\Auth;

use App\Models\Configuration;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class Login extends BaseLogin
{
    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill([
            'email' => 'academiaseuracha@seuracha.com',
            'password' => '12345678',
        ]);
    }

    public function getHeading(): string|Htmlable|null
    {
        $configuration = Configuration::first();
        $logoUrl = $configuration?->logo ? storage_url($configuration->logo) : null;

        if ($logoUrl) {
            return new HtmlString("
                <span class=\"ar-login-brand\">
                    <img src=\"{$logoUrl}\" alt=\"Logo da Academia\" class=\"ar-login-logo-img\">
                </span>
            ");
        }

        return new HtmlString('
            <span class="ar-login-brand">
                <span class="ar-login-logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                        <path d="M2 17l10 5 10-5"/>
                        <path d="M2 12l10 5 10-5"/>
                    </svg>
                </span>
            </span>
        ');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return new HtmlString('Painel Administrativo');
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::auth/pages/login.form.email.label'))
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->prefixIcon('heroicon-m-envelope');
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::auth/pages/login.form.password.label'))
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()" tabindex="-1">Esqueceu a senha?</x-filament::link>')) : null)
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->required()
            ->prefixIcon('heroicon-m-lock-closed');
    }
}
