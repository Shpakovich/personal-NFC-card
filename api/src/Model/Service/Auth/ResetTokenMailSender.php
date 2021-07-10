<?php

declare(strict_types=1);

namespace App\Model\Service\Auth;

use App\Model\Entity\User\Email;
use App\Model\Entity\User\Token;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class ResetTokenMailSender
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Email $email, Token $token): void
    {
        $message = (new \Symfony\Component\Mime\Email())
            ->to($email->getValue())
            ->subject('Reset token')
            ->text('Reset token: ' . $token->getValue())
            ->html('<p>Reset token: ' . $token->getValue() . '</p>');

        try {
            $this->mailer->send($message);
        } catch (TransportExceptionInterface $e) {
            throw new \RuntimeException('Unable send message. Error: ' . $e->getDebug());
        }
    }
}
