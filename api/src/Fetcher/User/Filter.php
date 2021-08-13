<?php

declare(strict_types=1);

namespace App\Fetcher\User;

class Filter
{
    private ?string $identity = null;
    private bool $isOnlyPublished = false;

    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    public function withIdentity(string $identity): self
    {
        $this->identity = $identity;
        return $this;
    }

    public function isOnlyPublished(): bool
    {
        return $this->isOnlyPublished;
    }

    public function withIsOnlyPublished(bool $isOnlyPublished): self
    {
        $this->isOnlyPublished = $isOnlyPublished;
        return $this;
    }
}
