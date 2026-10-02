<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;

class ConfiguredEmailPreview extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $templateType,
        public array $settings,
        public bool $isPreview = false,
        public bool $isBrowserPreview = false,
    ) {
    }

    public function build(): self
    {
        $verification = $this->templateType === 'verify';
        $prefix = $verification ? 'mail_verify' : 'mail_reset';
        $urlVariable = $verification ? 'verificationUrl' : 'resetUrl';
        $url = route('login');
        $view = $verification ? 'emails.verify-account' : 'emails.reset-password';
        $textView = $verification ? 'emails.verify-account-text' : 'emails.reset-password-text';

        $mail = $this->subject($this->settings[$prefix . '_subject'])
            ->view($view, [
                $urlVariable => $url,
                'mailIntro' => $this->settings[$prefix . '_intro'],
                'mailSignature' => $this->settings[$prefix . '_signature'],
                'isPreview' => $this->isPreview,
                'isBrowserPreview' => $this->isBrowserPreview,
            ])
            ->text($textView, [
                $urlVariable => $url,
                'mailIntro' => $this->settings[$prefix . '_intro'],
                'mailSignature' => $this->settings[$prefix . '_signature'],
                'isPreview' => $this->isPreview,
                'isBrowserPreview' => $this->isBrowserPreview,
            ]);

        return $mail->withSymfonyMessage(function (Email $message) {
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
}
