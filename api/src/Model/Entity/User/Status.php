<?php

declare(strict_types=1);

namespace App\Model\Entity\User;

use Webmozart\Assert\Assert;

class Status
{
    private const WAIT = 0;
    private const ACTIVE = 1;
    private const BLOCK = 2;

    private int $value;

    public function __construct(int $value)
    {
        Assert::oneOf($value, [
            self::WAIT,
            self::ACTIVE,
            self::BLOCK,
        ]);

        $this->value = $value;
    }

    public static function wait(): self
    {
        return new self(self::WAIT);
    }

    public static function active(): self
    {
        return new self(self::ACTIVE);
    }

    public static function block(): self
    {
        return new self(self::BLOCK);
    }

    public function isWait(): bool
    {
        return $this->value === self::WAIT;
    }

    public function isActive(): bool
    {
        return $this->value === self::ACTIVE;
    }

    public function isBlock(): bool
    {
        return $this->value === self::BLOCK;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
