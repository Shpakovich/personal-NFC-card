<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Favorite\Delete;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\FavoriteRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private FavoriteRepository $favorites;
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(
        FavoriteRepository $favorites,
        UserRepository $users,
        Flusher $flusher
    ) {
        $this->favorites = $favorites;
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $favorite = $this->favorites->getById(new Id($command->id));
        $user = $this->users->getById(new Id($command->userId));

        if (!$favorite->getUser()->getId()->isEqual($user->getId())) {
            throw new \DomainException('This favorite profile is not yours.');
        }

        $this->favorites->delete($favorite);
        $this->flusher->flush();
    }
}
