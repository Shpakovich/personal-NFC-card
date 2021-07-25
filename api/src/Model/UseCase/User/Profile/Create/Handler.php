<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Profile\Create;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\Profile;
use App\Model\Flusher;
use App\Model\Repository\ProfileRepository;
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

        $profile = new Profile(
            new Id($command->id),
            $user,
            !empty($command->title) ? $command->title : $command->name,
            $command->name,
            !empty($command->defaultName) ? $command->defaultName : Profile::DEFAULT_NAME,
            new \DateTimeImmutable()
        );

        if (!empty($command->cardId)) {
            $card = $this->userCards->getByCardId(new Id($command->cardId));
            if ($this->profiles->hasByCard($card)) {
                throw new \DomainException("Card {$command->cardId} already attach to profile.");
            }

            $profile->setCard($card);
        }

        $profile
            ->setNickname($command->nickname)
            ->setPost($command->post)
            ->setDescription($command->description);

        $this->profiles->add($profile);
        $this->flusher->flush();
    }
}
