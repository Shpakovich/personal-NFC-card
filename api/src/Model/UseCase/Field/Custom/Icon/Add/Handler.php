<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Custom\Icon\Add;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Field\CustomFieldRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private UserRepository $users;
    private CustomFieldRepository $fields;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        CustomFieldRepository $fields,
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

        if (!$field->getUser()->getId()->isEqual($user->getId())) {
            throw new \DomainException('It is not your custom field.');
        }

        $field
            ->setIconPath($command->icon->getFullPath())
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->flusher->flush();
    }
}
