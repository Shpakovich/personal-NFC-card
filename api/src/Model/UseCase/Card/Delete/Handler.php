<?php

declare(strict_types=1);

namespace App\Model\UseCase\Card\Delete;

use App\Model\Entity\Card\Id;
use App\Model\Flusher;
use App\Model\Repository\CardRepository;

class Handler
{
    private CardRepository $cards;
    private Flusher $flusher;

    public function __construct(CardRepository $cards, Flusher $flusher)
    {
        $this->cards = $cards;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $id = new Id($command->id);
        $card = $this->cards->getById($id);

        $this->cards->delete($card);
        $this->flusher->flush();
    }
}
