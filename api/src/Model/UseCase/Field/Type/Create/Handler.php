<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Type\Create;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\Type;
use App\Model\Flusher;
use App\Model\Repository\Field\TypeRepository;
use App\Model\Repository\UserRepository;

class Handler
{
    private TypeRepository $types;
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(TypeRepository $types, UserRepository $users, Flusher $flusher)
    {
        $this->types = $types;
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $id = new Id($command->id);
        $userId = new Id($command->userId);
        $user = $this->users->getById($userId);
        $type = new Type($id, $command->name, $command->sort, $user, new \DateTimeImmutable());

        if ($this->types->hasByName($type->getName())) {
            throw new \DomainException("Type '{$type->getName()}' already exists.");
        }

        $this->types->add($type);
        $this->flusher->flush();
    }
}
