<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Field\Create;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\Color;
use App\Model\Entity\Field\Field;
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
        $this->users = $users;
        $this->flusher = $flusher;
        $this->types = $types;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getById(new Id($command->userId));
        $type = $this->types->getById(new Id($command->typeId));

        $field = new Field(
            new Id($command->id),
            $command->title,
            $type,
            new Color($command->bgColor),
            new Color($command->textColor),
            $user,
            new \DateTimeImmutable()
        );

        if (!empty($command->help)) {
            $field->setHelp($command->help);
        }

        if (!empty($command->mask)) {
            $field->setMask($command->mask);
        }

        $this->fields->add($field);
        $this->flusher->flush();
    }
}
