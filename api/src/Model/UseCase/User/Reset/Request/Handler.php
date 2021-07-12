<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Reset\Request;

use App\Model\Entity\User\Email;
use App\Model\Flusher;
use App\Model\Repository\UserRepository;
use App\Model\Service\Auth\ResetTokenMailSender;
use App\Model\Service\Auth\Tokenizer;

class Handler
{
    private UserRepository $users;
    private Tokenizer $tokenizer;
    private ResetTokenMailSender $sender;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        Tokenizer $tokenizer,
        ResetTokenMailSender $sender,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->tokenizer = $tokenizer;
        $this->sender = $sender;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);
        $user = $this->users->findByEmail($email);

        if ($user === null) {
            throw new \DomainException("User {$email->getValue()} not found.");
        }

        if ($user->getStatus()->isBlock()) {
            throw new \DomainException('User is blocked.');
        }

        $resetToken = $this->tokenizer->generate(new \DateTimeImmutable());
        $user->setResetToken($resetToken);
        $this->flusher->flush();

        $this->sender->send($user->getEmail(), $resetToken);
    }
}
