<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\FieldCustom\Sort;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Profile\CustomFieldRepository as ProfileCustomFieldRepository;

class Handler
{
    private ProfileCustomFieldRepository $profileCustomFields;
    private Flusher $flusher;

    public function __construct(
        ProfileCustomFieldRepository $profileFields,
        Flusher $flusher
    ) {
        $this->profileCustomFields = $profileFields;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $field = $this->profileCustomFields->getById(new Id($command->id));

        if (!$field->getProfile()->getUser()->getId()->isEqual(new Id($command->userId))) {
            throw new \DomainException('It is not your profile.');
        }

        if ($field->getSort() === $command->sort) {
            return;
        }

        $field
            ->getProfile()
            ->setUpdatedAt(new \DateTimeImmutable())
            ->moveCustomField($field, $command->sort);

        $this->flusher->flush();
    }
}
