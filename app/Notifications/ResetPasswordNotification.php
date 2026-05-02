<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Notifikasi Reset Kata Sandi HelpDesk'))
            ->greeting(__('Halo') . ' ' . $notifiable->name . '!')
            ->line(__('Kami menerima permintaan reset kata sandi untuk akun Anda.'))
            ->action(__('Reset Kata Sandi'), url(config('app.url').route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
            ->line(__('Link reset kata sandi ini akan kadaluarsa dalam 60 menit.'))
            ->line(__('Jika Anda tidak melakukan permintaan reset kata sandi, tidak perlu tindakan lebih lanjut.'))
            ->salutation(__('Salam,') . "\n" . 'HelpDesk');
    }
}
