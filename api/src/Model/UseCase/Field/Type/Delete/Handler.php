<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Type\Delete;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Field\TypeRepository;

class Handler
{
    private TypeRepository $types;
    private Flusher $flusher;

    public function __construct(TypeRepository $types, Flusher $flusher)
    {
        $this->types = $types;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $id = new Id($command->id);
        $type = $this->types->getById($id);

        $this->types->delete($type);
        $this->flusher->flush();
    }
}
