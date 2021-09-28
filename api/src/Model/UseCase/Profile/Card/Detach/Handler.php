<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Card\Detach;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Profile\ProfileRepository;

class Handler
{
    private ProfileRepository $profiles;
    private Flusher $flusher;

    public function __construct(
        ProfileRepository $profiles,
        Flusher $flusher
    ) {
        $this->profiles = $profiles;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $profile = $this->profiles->getById(new Id($command->profileId));
        if (!$profile->hasCard()) {
            throw new \DomainException('Profile has no card.');
        }

        $profile->detachCard();
        $this->flusher->flush();
    }
}
