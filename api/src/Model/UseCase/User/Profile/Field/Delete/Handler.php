<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Profile\Field\Delete;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Profile\FieldRepository;

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

        if (!$field->getProfile()->getUser()->getId()->isEqual(new Id($command->userId))) {
            throw new \DomainException('It is not your profile.');
        }

        $this->fields->remove($field);
        $this->flusher->flush();
    }
}
