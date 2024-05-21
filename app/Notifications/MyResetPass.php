<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
class MyResetPass extends Notification
{
    public $token;

    public static $createUrlCallback;

    public static $toMailCallback;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return $this->buildMailMessage($this->resetUrl($notifiable));
    }

    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Запрос на сброс пароля'))
            ->line(Lang::get('Вы получили это письмо, потому что к нам поступил запрос на сброс пароля от Вашего аккаунта.'))
            ->action(Lang::get('Сбросить пароль'), $url)
            ->line(Lang::get('Срок действия этой ссылки истекает через :count минут.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('Если Вы не запрашивали сброс пароля, то никаких действий не требуется.'));
    }

    protected function resetUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        }

        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }

    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }

    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
