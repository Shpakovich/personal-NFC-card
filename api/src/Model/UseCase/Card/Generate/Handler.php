<?php

declare(strict_types=1);

namespace App\Model\UseCase\Card\Generate;

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
        $creator = $this->users->getById(new Id($command->userId));
        $now = new \DateTimeImmutable();

        for ($i = 0; $i < $command->count; ++$i) {
            $this->cards->add(new Card(Id::next(), $creator, $now));
        }

        $this->flusher->flush();
    }
}
