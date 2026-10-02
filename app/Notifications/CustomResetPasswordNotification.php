<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use App\Services\PlatformSettings;

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
        $settings = app(PlatformSettings::class)->all();

        return (new MailMessage)
            ->subject($settings['mail_reset_subject'])
            ->view('emails.reset-password', [
                'resetUrl' => $url,
                'mailIntro' => $settings['mail_reset_intro'],
                'mailSignature' => $settings['mail_reset_signature'],
            ])
            ->text('emails.reset-password-text', [
                'resetUrl' => $url,
                'mailIntro' => $settings['mail_reset_intro'],
                'mailSignature' => $settings['mail_reset_signature'],
            ])
            ->withSymfonyMessage(function (Email $message) {
                $logos = [
                    'logo-pgde@pgde' => public_path('images/logoPGDE-email.png'),
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
