<?php

declare(strict_types=1);

namespace App\Model\Service\Auth;

use App\Model\Entity\User\Email;
use App\Model\Entity\User\Token;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class ConfirmTokenMailSender
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
            ->subject('Confirm email')
            ->text('Confirm token: ' . $token->getValue())
            ->html('<p>Confirm token: ' . $token->getValue() . '</p>');

        $this->mailer->send($message);
    }
}
