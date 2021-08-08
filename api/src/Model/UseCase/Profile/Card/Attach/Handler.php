<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Card\Attach;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\Repository\UserCardRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private UserRepository $users;
    private UserCardRepository $userCards;
    private ProfileRepository $profiles;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        UserCardRepository $userCards,
        ProfileRepository $profiles,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->userCards = $userCards;
        $this->profiles = $profiles;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getById(new Id($command->userId));
        $profile = $this->profiles->getById(new Id($command->profileId));
        $card = $this->userCards->getByCardId(new Id($command->cardId));

        if (!$profile->getUser()->getId()->isEqual($user->getId())) {
            throw new \DomainException('It is not your profile.');
        }

        if (!$card->getUser()->getId()->isEqual($user->getId())) {
            throw new \DomainException('It is not your card.');
        }

        if ($profile->hasCard()) {
            throw new \DomainException("Profile already attached card.");
        }

        $profile->setCard($card);
        $this->flusher->flush();
    }
}
