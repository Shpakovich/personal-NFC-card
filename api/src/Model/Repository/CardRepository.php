<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\Card\Card;
use App\Model\Entity\Common\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CardRepository
{
    private EntityManagerInterface $em;

    /** @var \Doctrine\ORM\EntityRepository<\App\Model\Entity\Card\Card> */
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repo = $em->getRepository(Card::class);
    }

    public function add(Card $card): void
    {
        $this->em->persist($card);
    }

    public function delete(Card $card): void
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

    public function getById(Id $id): Card
    {
        $card = $this->repo->find($id);
        if ($card !== null) {
            return $card;
        }

        throw new \DomainException("Card {$id->getValue()} not found.");
    }
}
