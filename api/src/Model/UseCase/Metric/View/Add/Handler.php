<?php

declare(strict_types=1);

namespace App\Model\UseCase\Metric\View\Add;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Metric\View;
use App\Model\Flusher;
use App\Model\Repository\Metric\ViewRepository;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\Repository\UserCardRepository;

class Handler
{
    private UserCardRepository $cards;
    private ProfileRepository $profiles;
    private ViewRepository $views;
    private Flusher $flusher;

    public function __construct(
        UserCardRepository $cards,
        ProfileRepository $profiles,
        ViewRepository $views,
        Flusher $flusher
    ) {
        $this->cards = $cards;
        $this->profiles = $profiles;
        $this->views = $views;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $card = $this->cards->getById(new Id($command->userCardId));
        $profile = $this->profiles->getById(new Id($command->profileId));

        $profileCard = $profile->getCard();
        if ($profileCard === null || !$profileCard->getId()->isEqual($card->getId())) {
            throw new \DomainException('Wrong card or profile.');
        }

        if (!$profile->isPublished()) {
            throw new \DomainException('Profile is not published.');
        }

        $view = new View(
            new Id($command->id),
            new \DateTimeImmutable(),
            $card,
            $profile
        );

        $this->views->add($view);
        $this->flusher->flush();
    }
}
