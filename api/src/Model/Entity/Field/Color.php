<?php

declare(strict_types=1);

namespace App\Model\Entity\Field;

use Webmozart\Assert\Assert;

class Color
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::regex($value, '/^#[\da-fA-F]{3,6}$/');

        $this->value = strtolower($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Color $color): bool
    {
        return $this->value === $color->value;
    }
}
