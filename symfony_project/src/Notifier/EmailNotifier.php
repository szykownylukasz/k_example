<?php

namespace App\Notifier;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotifier implements NotifierInterface
{
    private MailerInterface $mailer;
    private string $recipient;

    public function __construct(MailerInterface $mailer, string $recipient)
    {
        $this->mailer = $mailer;
        $this->recipient = $recipient;
    }

    public function notify(string $message): void
    {
        $email = (new Email())
            ->from('noreply@example.com')
            ->to($this->recipient)
            ->subject('Powiadomienie o produkcie')
            ->text($message);

        $this->mailer->send($email);
    }
}
