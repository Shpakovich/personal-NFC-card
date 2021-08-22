<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Field\Sort;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Profile\FieldRepository as ProfileFieldRepository;

class Handler
{
    private ProfileFieldRepository $profileFields;
    private Flusher $flusher;

    public function __construct(ProfileFieldRepository $profileFields, Flusher $flusher)
    {
        $this->profileFields = $profileFields;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $field = $this->profileFields->getById(new Id($command->id));

        if (!$field->getProfile()->getUser()->getId()->isEqual(new Id($command->userId))) {
            throw new \DomainException('It is not your profile.');
        }

        if ($field->getSort() === $command->sort) {
            return;
        }

        $field
            ->getProfile()
            ->moveField($field, $command->sort);

        $this->flusher->flush();
    }
}
