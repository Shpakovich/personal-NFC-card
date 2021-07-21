<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\Card\Card;
use App\Model\Entity\Common\Id;
use App\Model\Entity\User\UserCard;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserCardRepository
{
    private EntityManagerInterface $em;

    /** @var \Doctrine\ORM\EntityRepository<\App\Model\Entity\User\UserCard> */
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repo = $em->getRepository(UserCard::class);
    }

    public function add(UserCard $card): void
    {
        $this->em->persist($card);
    }

    public function hasByCard(Card $card): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->where('t.card = :card')
                ->setParameter(':card', $card)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasByAlias(string $alias): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->where('t.alias = :alias')
                ->setParameter(':alias', $alias)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function getByCardId(Id $id): UserCard
    {
        $card = $this->repo->findOneBy(['card' => $id]);
        if ($card !== null) {
            return $card;
        }

        throw new \DomainException('User card not found.');
    }
}
