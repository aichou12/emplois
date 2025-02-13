<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this->resetUrl($notifiable); // URL de réinitialisation

        return (new MailMessage)
            ->subject('Réinitialisez votre mot de passe')
            ->greeting('Bonjour,')
            ->line('Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.')
            ->action('Réinitialiser mon mot de passe', $url)
            ->line('Ce lien de réinitialisation expirera dans 15 minutes.')
            ->line('Si vous n\'avez pas demandé de réinitialisation de mot de passe, veuillez ignorer cet email.')
            ->salutation('Cordialement, l\'équipe PGDE');
    }

    /**
     * Generate the reset password URL.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
}
