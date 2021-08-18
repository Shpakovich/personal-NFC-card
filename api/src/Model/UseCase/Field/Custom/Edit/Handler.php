<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Custom\Edit;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\Color;
use App\Model\Flusher;
use App\Model\Repository\Field\CustomFieldRepository;
use App\Model\Repository\Field\FieldRepository;
use App\Model\Repository\Field\TypeRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private CustomFieldRepository $fields;
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(
        CustomFieldRepository $fields,
        UserRepository $users,
        Flusher $flusher
    ) {
        $this->fields = $fields;
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getById(new Id($command->userId));
        $field = $this->fields->getById(new Id($command->id));

        if (!$field->getUser()->getId()->isEqual($user->getId())) {
            throw new \DomainException('It is not your custom field.');
        }

        $field
            ->setTitle($command->title)
            ->setBgColor(new Color($command->bgColor))
            ->setTextColor(new Color($command->textColor))
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->flusher->flush();
    }
}
