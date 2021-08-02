<?php

declare(strict_types=1);

namespace App\Model\Repository\Field;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\Type;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class TypeRepository
{
    private EntityManagerInterface $em;

    /** @var \Doctrine\ORM\EntityRepository<\App\Model\Entity\Card\Card> */
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repo = $em->getRepository(Type::class);
    }

    public function add(Type $card): void
    {
        $this->em->persist($card);
    }

    public function delete(Type $card): void
    {
        $this->em->remove($card);
    }

    public function hasById(Id $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->where('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
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

    public function getById(Id $id): Type
    {
        $card = $this->repo->find($id);
        if ($card !== null) {
            return $card;
        }

        throw new \DomainException("Type {$id->getValue()} not found.");
    }
}
