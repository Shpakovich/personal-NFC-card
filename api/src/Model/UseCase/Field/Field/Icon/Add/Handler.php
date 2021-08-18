<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Field\Icon\Add;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Field\FieldRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;
    private FieldRepository $fields;

    public function __construct(
        UserRepository $users,
        FieldRepository $fields,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->fields = $fields;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getById(new Id($command->userId));
        $field = $this->fields->getById(new Id($command->fieldId));

        $field
            ->setIconPath($command->icon->getFullPath())
            ->setEditor($user)
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->flusher->flush();
    }
}
