<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Messages\MailMessage;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;

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
            ->subject('Activez votre compte sur la plateforme PGDE')
            ->view('emails.verify-account', ['verificationUrl' => $url])
            ->text('emails.verify-account-text', ['verificationUrl' => $url])
            ->withSymfonyMessage(function (Email $message) {
                $logos = [
                    'logo-pgde@pgde' => public_path('images/logoPGDE.png'),
                    'logo-mfp@pgde' => public_path('images/mfp.png'),
                ];

                foreach ($logos as $contentId => $path) {
                    if (is_file($path)) {
                        $message->addPart(
                            DataPart::fromPath($path, basename($path), 'image/png')
                                ->asInline()
                                ->setContentId($contentId)
                        );
                    }
                }
            });
    }

    /**
     * Générer une URL de vérification personnalisée à durée limitée.
     */
    protected function verificationUrl($notifiable)
    {
        // Générez un lien signé et temporaire (60 minutes)
        return URL::temporarySignedRoute(
            'verification.verify', // Nom de la route
            now()->addMinutes(60), // Délai raisonnable pour consulter ses emails
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
