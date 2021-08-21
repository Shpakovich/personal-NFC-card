<?php

declare(strict_types=1);

namespace App\Event\Profile;

class ShowEvent
{
    private string $userCardId;
    private string $profileId;

    public function __construct(string $userCardId, string $profileId)
    {
        $this->userCardId = $userCardId;
        $this->profileId = $profileId;
    }

    public function getUserCardId(): string
    {
        return $this->userCardId;
    }

    public function getProfileId(): string
    {
        return $this->profileId;
    }
}
