<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Reset\Confirm;

use App\Model\Flusher;
use App\Model\Repository\UserRepository;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class Handler
{
    private UserRepository $users;
    private PasswordHasherInterface $hasher;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        PasswordHasherInterface $hasher,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->findByResetToken($command->token);
        if ($user === null) {
            throw new \DomainException('Reset token not found.');
        }

        if ($user->getStatus()->isBlock()) {
            throw new \DomainException('User is blocked.');
        }

        $now = new \DateTimeImmutable();
        /** @var \App\Model\Entity\User\Token $token */
        $token = $user->getResetToken();
        if ($token->isExpired($now)) {
            throw new \DomainException('Reset token expired.');
        }

        $user
            ->setPasswordHash($this->hasher->hash($command->password))
            ->setUpdatedAt($now);

        $this->flusher->flush();
    }
}
