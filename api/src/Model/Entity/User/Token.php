<?php

declare(strict_types=1);

namespace App\Model\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Token
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $value;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private \DateTimeImmutable $expires;

    public function __construct(string $value, \DateTimeImmutable $expires)
    {
        Assert::uuid($value);
        $this->value = $value;
        $this->expires = $expires;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isExpired(\DateTimeImmutable $data): bool
    {
        return $data >= $this->expires;
    }

    public function isEqual(Token $token): bool
    {
        return $this->value === $token->getValue();
    }
}
