<?php

declare(strict_types=1);

namespace App\Security;

use App\Model\Entity\User\Status;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserIdentity implements UserInterface, PasswordAuthenticatedUserInterface, EquatableInterface
{
    private string $id;
    private string $username;
    private string $password;
    private int $status;

    public function __construct(string $id, string $username, string $password, int $status)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function isActive(): bool
    {
        return $this->status === Status::ACTIVE;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof self) {
            return false;
        }

        return $this->id === $user->id
            && $this->username === $user->username
            && $this->password === $user->password;
    }
}
