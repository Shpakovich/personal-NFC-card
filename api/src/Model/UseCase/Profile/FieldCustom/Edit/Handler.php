<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\FieldCustom\Edit;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Field\CustomFieldRepository;
use App\Model\Repository\Profile\CustomFieldRepository as ProfileCustomFieldRepository;

class Handler
{
    private ProfileCustomFieldRepository $profileFields;
    private CustomFieldRepository $fields;
    private Flusher $flusher;

    public function __construct(
        ProfileCustomFieldRepository $profileFields,
        CustomFieldRepository $fields,
        Flusher $flusher
    ) {
        $this->profileFields = $profileFields;
        $this->fields = $fields;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $profileField = $this->profileFields->getById(new Id($command->id));

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
