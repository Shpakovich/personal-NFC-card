<?php

declare(strict_types=1);

namespace App\Model\Entity\User;

class ConfirmEmail
{
    private Token $token;
    private \DateTimeImmutable $expired;

    public function __construct(Token $token, \DateTimeImmutable $expired)
    {
        $this->token = $token;
        $this->expired = $expired;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function isExpired(): bool
    {
        return new \DateTimeImmutable() > $this->expired;
    }
}
