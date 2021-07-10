<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Signup\Confirm;

use App\Model\Flusher;
use App\Model\Repository\UserRepository;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->findByConfirmToken($command->token);
        if ($user === null) {
            throw new \DomainException('Confirm token not found.');
        }

        /** @var \App\Model\Entity\User\Token $token */
        $token = $user->getConfirmToken();
        if ($token->isExpired(new \DateTimeImmutable())) {
            throw new \DomainException('Confirm token expired.');
        }

        $user->confirm();
        $this->flusher->flush();
    }
}
