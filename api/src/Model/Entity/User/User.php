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
    private ?\DateTimeImmutable $lastAuthAt = null;

    public function __construct(
        Id $id,
        Email $email,
        string $passwordHash,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->status = Status::wait();
    }

    /**
     * @return \App\Model\Entity\User\Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getConfirmEmail(): ?ConfirmEmail
    {
        return $this->confirmEmail;
    }

    public function setConfirmEmail(?ConfirmEmail $confirmEmail): void
    {
        $this->confirmEmail = $confirmEmail;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getLastAuthAt(): ?\DateTimeImmutable
    {
        return $this->lastAuthAt;
    }

    public function setLastAuthAt(\DateTimeImmutable $lastAuthAt): void
    {
        $this->lastAuthAt = $lastAuthAt;
    }
}
