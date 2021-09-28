<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Card\Attach;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\Repository\UserCardRepository;

class Handler
{
    private UserCardRepository $userCards;
    private ProfileRepository $profiles;
    private Flusher $flusher;

    public function __construct(
        UserCardRepository $userCards,
        ProfileRepository $profiles,
        Flusher $flusher
    ) {
        $this->userCards = $userCards;
        $this->profiles = $profiles;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $profile = $this->profiles->getById(new Id($command->profileId));
        $card = $this->userCards->getByCardId(new Id($command->cardId));

        if ($profile->hasCard()) {
            throw new \DomainException("Profile already attached card.");
        }

        $profile->setCard($card);
        $this->flusher->flush();
    }
}
