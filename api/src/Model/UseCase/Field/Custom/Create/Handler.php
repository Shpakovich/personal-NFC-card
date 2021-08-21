<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Custom\Create;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\Color;
use App\Model\Entity\Field\CustomField;
use App\Model\Flusher;
use App\Model\Repository\Field\CustomFieldRepository;
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

        $field = new CustomField(
            new Id($command->id),
            $user,
            $command->title,
            new Color($command->bgColor),
            new Color($command->textColor),
            new \DateTimeImmutable()
        );

        $this->fields->add($field);
        $this->flusher->flush();
    }
}
