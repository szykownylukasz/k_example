<?php

namespace App\Tests\Notifier;

use App\Notifier\EmailNotifier;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotifierTest extends TestCase
{
    public function testNotifySendsEmail(): void
    {
        $mailer = $this->createMock(MailerInterface::class);
        $recipient = 'admin@example.com';
        $notifier = new EmailNotifier($mailer, $recipient);

        $mailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function (Email $email) use ($recipient) {
                return $email->getTo()[0]->getAddress() === $recipient
                    && 'Powiadomienie o produkcie' === $email->getSubject()
                    && 'Testowa wiadomość' === $email->getTextBody();
            }));

        $notifier->notify('Testowa wiadomość');
    }
}
