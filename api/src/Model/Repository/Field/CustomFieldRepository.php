<?php

declare(strict_types=1);

namespace App\Model\Repository\Field;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\CustomField;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CustomFieldRepository
{
    private EntityManagerInterface $em;

    /** @var \Doctrine\ORM\EntityRepository<\App\Model\Entity\Field\CustomField> */
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(CustomField::class);
    }

    public function add(CustomField $field): void
    {
        $this->em->persist($field);
    }

    public function delete(CustomField $field): void
    {
        $this->em->remove($field);
    }

    public function getById(Id $id): CustomField
    {
        $field = $this->repo->find($id);
        if ($field !== null) {
            return $field;
        }

        throw new \DomainException("Field '{$id->getValue()}' not found.");
    }
}
