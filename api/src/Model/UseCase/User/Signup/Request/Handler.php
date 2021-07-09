<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Signup\Request;

use App\Model\Entity\User\Email;
use App\Model\Entity\User\Id;
use App\Model\Entity\User\User;
use App\Model\Flusher;
use App\Model\Repository\UserRepository;
use App\Model\Service\Auth\ConfirmTokenMailSender;
use App\Model\Service\Auth\PasswordHasher;
use App\Model\Service\Auth\Tokenizer;

class Handler
{
    private UserRepository $users;
    private PasswordHasher $hasher;
    private Tokenizer $tokenizer;
    private ConfirmTokenMailSender $sender;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        PasswordHasher $hasher,
        Tokenizer $tokenizer,
        ConfirmTokenMailSender $sender,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->tokenizer = $tokenizer;
        $this->sender = $sender;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new \DomainException("User {$email->getValue()} already exists.");
        }

        $now = new \DateTimeImmutable();
        $confirmToken = $this->tokenizer->generate($now);

        $user = new User(
            Id::next(),
            $email,
            $this->hasher->hash($command->password),
            $confirmToken,
            $now,
            $now
        );

        $this->users->add($user);
        $this->flusher->flush();

        $this->sender->send($email, $confirmToken);
    }
}
