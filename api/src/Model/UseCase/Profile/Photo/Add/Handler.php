<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Photo\Add;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private UserRepository $users;
    private ProfileRepository $profiles;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        ProfileRepository $profiles,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->profiles = $profiles;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getById(new Id($command->userId));
        $profile = $this->profiles->getById(new Id($command->profileId));

        if (!$profile->getUser()->getId()->isEqual($user->getId())) {
            throw new \DomainException('It is not your profile.');
        }

        $profile
            ->setPhotoPath($command->file->getFullPath())
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->flusher->flush();
    }
}
