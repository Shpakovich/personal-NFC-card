<?php

declare(strict_types=1);

namespace App\Model\Service\Auth;

use App\Model\Entity\User\Email;
use App\Model\Entity\User\Token;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class ResetTokenMailSender
{
    private MailerInterface $mailer;
    private Environment $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function send(Email $email, Token $token): void
    {
        $html = $this->twig->render('mail/user/reset.html.twig', [
            'token' => $token->getValue()
        ]);

        $message = (new \Symfony\Component\Mime\Email())
            ->to($email->getValue())
            ->subject('Запрос на изменение пароля')
            ->html($html);

        $this->mailer->send($message);
    }
}
