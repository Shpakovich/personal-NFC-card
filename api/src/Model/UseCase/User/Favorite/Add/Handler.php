<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Favorite\Add;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\Favorite;
use App\Model\Flusher;
use App\Model\Repository\FavoriteRepository;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private FavoriteRepository $favorites;
    private ProfileRepository $profiles;
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(
        FavoriteRepository $favorites,
        ProfileRepository $profiles,
        UserRepository $users,
        Flusher $flusher
    ) {
        $this->favorites = $favorites;
        $this->profiles = $profiles;
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getById(new Id($command->userId));
        $profile = $this->profiles->getById(new Id($command->profileId));

        if ($profile->getUser()->getId()->isEqual($user->getId())) {
            throw new \DomainException('This profile is yours.');
        }

        $favorite = new Favorite(
            Id::next(),
            $user,
            $profile
        );

        $this->favorites->add($favorite);
        $this->flusher->flush();
    }
}
