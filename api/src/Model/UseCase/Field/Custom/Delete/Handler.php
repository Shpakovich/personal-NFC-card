<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Custom\Delete;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Field\CustomFieldRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private CustomFieldRepository $fields;
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(CustomFieldRepository $fields, UserRepository $users, Flusher $flusher)
    {
        $this->fields = $fields;
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $field = $this->fields->getById(new Id($command->id));
        $user = $this->users->getById(new Id($command->userId));

        if (!$field->getUser()->getId()->isEqual($user->getId())) {
            throw new \DomainException('It is not your custom field.');
        }

        $this->fields->delete($field);
        $this->flusher->flush();
    }
}
