<?php

declare(strict_types=1);

namespace App\Model\Entity\User;

class User
{
    private Id $id;
    private Email $email;
    private ?ConfirmEmail $confirmEmail = null;
    private string $passwordHash;
    private Status $status;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;
    private \DateTimeImmutable $lastAuthAt;

    public function __construct(Id $id, Email $email, string $passwordHash)
    {
        $this->id = $id;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }
}
