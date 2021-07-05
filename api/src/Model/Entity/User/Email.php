<?php

declare(strict_types=1);

namespace App\Model\Entity\User;

use Webmozart\Assert\Assert;

class Email
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::email($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Email $email): bool
    {
        return $this->value === $email->getValue();
    }
}
