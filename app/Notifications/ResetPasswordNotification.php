<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Config;

class ResetPasswordNotification extends Notification
{
    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $expire = Config::get('auth.passwords.'.Config::get('auth.defaults.passwords').'.expire');

        return (new MailMessage)
            ->subject('Restablecer Contraseña — Comunal Aprende')
            ->markdown('auth.reset-password-email', [
                'url'    => $url,
                'name'   => $notifiable->name,
                'expire' => $expire,
            ]);
    }
}