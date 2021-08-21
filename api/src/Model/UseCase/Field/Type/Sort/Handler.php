<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Type\Sort;

use App\Model\Entity\Common\Id;
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
        $user = $this->users->getById(new Id($command->userId));
        $type = $this->types->getById(new Id($command->id));

        $type
            ->setSort($command->sort)
            ->setEditor($user)
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->flusher->flush();
    }
}
