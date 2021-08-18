<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Field\Icon\Remove;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Field\FieldRepository;
use App\Model\Repository\UserRepository;
use App\Model\Service\Storage\Storage;

class Handler
{
    private UserRepository $users;
    private FieldRepository $fields;
    private Storage $storage;
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        FieldRepository $fields,
        Storage $storage,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->fields = $fields;
        $this->storage = $storage;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getById(new Id($command->userId));
        $field = $this->fields->getById(new Id($command->fieldId));

        $path = $field->getIconPath();

        $field
            ->removeIconPath()
            ->setEditor($user)
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->flusher->flush();

        $this->storage->delete($path);
    }
}
