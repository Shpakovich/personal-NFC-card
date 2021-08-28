<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Field\Edit;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\Color;
use App\Model\Flusher;
use App\Model\Repository\Field\FieldRepository;
use App\Model\Repository\Field\TypeRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private FieldRepository $fields;
    private TypeRepository $types;
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(
        FieldRepository $fields,
        TypeRepository $types,
        UserRepository $users,
        Flusher $flusher
    ) {
        $this->fields = $fields;
        $this->types = $types;
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getById(new Id($command->userId));
        $field = $this->fields->getById(new Id($command->id));
        $type = $this->types->getById(new Id($command->typeId));

        $field
            ->setTitle($command->title)
            ->setBgColor(new Color($command->bgColor))
            ->setTextColor(new Color($command->textColor))
            ->setHelp(!empty($command->help) ? $command->help : null)
            ->setMask(!empty($command->mask) ? $command->mask : null)
            ->setType($type)
            ->setEditor($user)
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->flusher->flush();
    }
}
