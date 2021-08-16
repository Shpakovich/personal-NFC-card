<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Create;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\Email;
use App\Model\Entity\User\Role;
use App\Model\Entity\User\Status;
use App\Model\Entity\User\User;
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
        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new \DomainException("User {$email->getValue()} already exists.");
        }

        $user = new User(
            Id::next(),
            $email,
            $this->hasher->hash($command->password),
            null,
            new Role($command->role),
            new \DateTimeImmutable()
        );
        $user->setStatus(new Status($command->status));

        $this->users->add($user);
        $this->flusher->flush();
    }
}
