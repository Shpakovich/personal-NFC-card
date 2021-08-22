<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Field\Edit;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Field\FieldRepository;
use App\Model\Repository\Profile\FieldRepository as ProfileFieldRepository;

class Handler
{
    private ProfileFieldRepository $profileFields;
    private FieldRepository $fields;
    private Flusher $flusher;

    public function __construct(ProfileFieldRepository $profileFields, FieldRepository $fields, Flusher $flusher)
    {
        $this->profileFields = $profileFields;
        $this->fields = $fields;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $profileField = $this->profileFields->getById(new Id($command->id));

        if (!$profileField->getProfile()->getUser()->getId()->isEqual(new Id($command->userId))) {
            throw new \DomainException('It is not your profile.');
        }

        $profileField
            ->setValue($command->value)
            ->getProfile()->setUpdatedAt(new \DateTimeImmutable());

        if (!empty($command->fieldId)) {
            $field = $this->fields->getById(new Id($command->fieldId));
            $profileField->setField($field);
        }

        $this->flusher->flush();
    }
}
