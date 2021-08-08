<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Field\Delete;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Field\FieldRepository;

class Handler
{
    private FieldRepository $fields;
    private Flusher $flusher;

    public function __construct(FieldRepository $fields, Flusher $flusher)
    {
        $this->fields = $fields;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $field = $this->fields->getById(new Id($command->id));

        $this->fields->delete($field);
        $this->flusher->flush();
    }
}
