<?php

declare(strict_types=1);

namespace App\Model\Entity\User;

use Ramsey\Uuid\Uuid;

class Token
{
    private string $value;

    public function __construct()
    {
        $this->value = Uuid::uuid4()->toString();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Token $token): bool
    {
        return $this->value === $token->getValue();
    }
}
