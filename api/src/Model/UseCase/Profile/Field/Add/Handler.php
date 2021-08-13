<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Field\Add;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Profile\Field;
use App\Model\Flusher;
use App\Model\Repository\Field\FieldRepository;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private UserRepository $users;
    private ProfileRepository $profiles;
    private FieldRepository $fields;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        ProfileRepository $profiles,
        FieldRepository $fields,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->profiles = $profiles;
        $this->fields = $fields;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getById(new Id($command->userId));
        $profile = $this->profiles->getById(new Id($command->profileId));
        $field = $this->fields->getById(new Id($command->fieldId));

        if (!$profile->getUser()->getEmail()->isEqual($user->getEmail())) {
            throw new \DomainException('It is not your profile.');
        }

        $profile
            ->addField(new Field(new Id($command->id), $profile, $field, $command->value, $command->sort))
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->profiles->add($profile);
        $this->flusher->flush();
    }
}
