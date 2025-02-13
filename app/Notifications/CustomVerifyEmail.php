<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    /**
     * Construire un email de vérification personnalisé.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('Confirmez votre adresse email')
            ->greeting('Bonjour,')
            ->line('Merci de vous être inscrit sur notre plateforme.')
            ->line('Pour activer votre compte, veuillez cliquer sur le bouton ci-dessous.')
            ->action('Vérifier mon adresse email', $url)
            ->line('Ce lien d\'activation expirera dans 15 minutes.')
            ->line('Si vous n\'êtes pas à l\'origine de cette inscription, aucune action n\'est requise.')
            ->salutation('Cordialement, l\'équipe PGDE');
    }

    /**
     * Générer l'URL de vérification personnalisée avec expiration (15 minutes).
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify', // Nom de la route
            Carbon::now()->addMinutes(15), // Durée de validité du lien
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
