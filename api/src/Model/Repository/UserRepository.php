<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\User\Email;
use App\Model\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        /** @var EntityRepository $repo */
        $repo = $em->getRepository(User::class);
        $this->repo = $repo;
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }

    public function hasByEmail(Email $email): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->where('t.email = :email')
                ->setParameter(':email', $email->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function findByConfirmToken(string $token): ?User
    {
        return $this->repo->findOneBy(['confirmToken.value' => $token]);
    }
}
