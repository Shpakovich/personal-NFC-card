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

        $profileField
            ->setSort($command->sort)
            ->getProfile()->setUpdatedAt(new \DateTimeImmutable());

        $this->flusher->flush();
    }
}
