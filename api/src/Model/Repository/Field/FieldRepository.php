<?php

declare(strict_types=1);

namespace App\Model\Repository\Field;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\Field;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class FieldRepository
{
    private EntityManagerInterface $em;

    /** @var \Doctrine\ORM\EntityRepository<\App\Model\Entity\Field\Field> */
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repo = $em->getRepository(Field::class);
    }

    public function add(Field $field): void
    {
        $this->em->persist($field);
    }

    public function delete(Field $field): void
    {
        $this->em->remove($field);
    }

    public function hasByName(string $name, ?Id $exclude = null): bool
    {
        $qb = $this->repo->createQueryBuilder('t');
        $qb->select('COUNT(t.id)')
            ->where('lower(t.name) = lower(:name)')
            ->setParameter(':name', $name);

        if ($exclude !== null) {
            $qb->andWhere('t.id <> :id')
                ->setParameter('id', $exclude->getValue());
        }

        return $qb->getQuery()->getSingleScalarResult() > 0;
    }

    public function getById(Id $id): Field
    {
        $field = $this->repo->find($id);
        if ($field !== null) {
            return $field;
        }

        throw new \DomainException("Field '{$id->getValue()}' not found.");
    }
}
