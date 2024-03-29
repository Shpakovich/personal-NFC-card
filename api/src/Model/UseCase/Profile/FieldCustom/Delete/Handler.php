<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\FieldCustom\Delete;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Profile\CustomFieldRepository;

class Handler
{
    private CustomFieldRepository $fields;
    private Flusher $flusher;

    public function __construct(CustomFieldRepository $fields, Flusher $flusher)
    {
        $this->fields = $fields;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $field = $this->fields->getById(new Id($command->id));

        $this->fields->remove($field);
        $this->flusher->flush();
    }
}
