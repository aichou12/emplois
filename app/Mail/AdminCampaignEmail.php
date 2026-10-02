<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;

class AdminCampaignEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $campaignSubject, public string $campaignBody)
    {
    }

    public function build(): self
    {
        return $this->subject($this->campaignSubject)
            ->view('emails.admin-campaign', ['campaignBody' => $this->campaignBody, 'campaignSubject' => $this->campaignSubject])
            ->text('emails.admin-campaign-text', ['campaignBody' => $this->campaignBody, 'campaignSubject' => $this->campaignSubject])
            ->withSymfonyMessage(function (Email $message) {
                foreach ([
                    'logo-pgde@pgde' => public_path('images/logoPGDE-email.png'),
                    'logo-mfp@pgde' => public_path('images/mfp.png'),
                ] as $contentId => $path) {
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
