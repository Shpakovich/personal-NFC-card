<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Card\Register;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\UserCard;
use App\Model\Flusher;
use App\Model\Repository\CardRepository;
use App\Model\Repository\UserCardRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private CardRepository $cards;
    private UserRepository $users;
    private UserCardRepository $userCards;
    private Flusher $flusher;

    public function __construct(
        CardRepository $cards,
        UserRepository $users,
        UserCardRepository $userCards,
        Flusher $flusher
    ) {
        $this->cards = $cards;
        $this->users = $users;
        $this->userCards = $userCards;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getById(new Id($command->userId));
        $card = $this->cards->getById(new Id($command->id));

        if ($this->userCards->hasByCard($card)) {
            throw new \DomainException("Card '{$command->id}' already registered.");
        }

        if (!empty($command->alias) && $this->userCards->hasByAlias($command->alias)) {
            throw new \DomainException("Card with alias '{$command->alias}' already registered.");
        }

        $userCard = new UserCard(
            Id::next(),
            $user,
            $card,
            new \DateTimeImmutable(),
            !empty($command->alias) ? $command->alias : null
        );

        $this->userCards->add($userCard);
        $this->flusher->flush();
    }
}
