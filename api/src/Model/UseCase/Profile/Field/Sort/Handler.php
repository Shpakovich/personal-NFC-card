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
        $profileField = $this->profileFields->getById(new Id($command->id));

        if (!$profileField->getProfile()->getUser()->getId()->isEqual(new Id($command->userId))) {
            throw new \DomainException('It is not your profile.');
        }

        if ($profileField->getSort() === $command->sort) {
            return;
        }

        // UP
        if ($profileField->getSort() > $command->sort) {
            /** @var \App\Model\Entity\Profile\Field $field */
            foreach ($profileField->getProfile()->getFields() as $field) {
                if ($field->getId()->isEqual(new Id($command->id))) {
                    break;
                }

                if ($field->getSort() < $command->sort) {
                    continue;
                }

                $field->setSort($field->getSort() + 1);
            }
        }

        // DOWN
        if ($profileField->getSort() < $command->sort) {
            /** @var \App\Model\Entity\Profile\Field $field */
            foreach ($profileField->getProfile()->getFields() as $field) {
                if ($field->getSort() <= $profileField->getSort()) {
                    continue;
                }

                if ($field->getSort() > $command->sort) {
                    break;
                }

                $field->setSort($field->getSort() - 1);
            }
        }

        $profileField->setSort($command->sort);
        $this->flusher->flush();
    }
}
