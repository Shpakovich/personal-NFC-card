<?php

declare(strict_types=1);

namespace App\Model\UseCase\Card\Create;

use App\Model\Entity\Card\Card;
use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\CardRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private CardRepository $cards;
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(CardRepository $cards, UserRepository $users, Flusher $flusher)
    {
        $this->cards = $cards;
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $id = new Id($command->id);
        if ($this->cards->hasById($id)) {
            throw new \DomainException("Card {$id->getValue()} already exists.");
        }

        $userId = new Id($command->userId);
        $user = $this->users->getById($userId);
        $card = new Card($id, $user, new \DateTimeImmutable());

        $this->cards->add($card);
        $this->flusher->flush();
    }
}
