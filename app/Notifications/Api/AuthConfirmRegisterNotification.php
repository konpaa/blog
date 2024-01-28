<?php

namespace App\Notifications\Api;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AuthConfirmRegisterNotification extends Notification
{
    public function __construct()
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $code = Str::random(50);
        Cache::put('register:' . $code, $notifiable->id);
        $url = route('confirm', ['code' => $code]);
        return (new MailMessage())
            ->greeting(__('content.confirm_mail_letter.greeting'))
            ->salutation(__('content.confirm_mail_letter.salutation'))
            ->action('Click his', $url);
    }

    public function toArray($notifiable)
    {
        return [];
    }
}
