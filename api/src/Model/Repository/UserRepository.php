<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\User\Email;
use App\Model\Entity\User\Id;
use App\Model\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository
{
    private EntityManagerInterface $em;

    /** @var \Doctrine\ORM\EntityRepository<\App\Model\Entity\User\User> */
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repo = $em->getRepository(User::class);
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

    public function getById(Id $id): User
    {
        $user = $this->repo->find($id);
        if ($user !== null) {
            return $user;
        }

        throw new \DomainException("User {$id->getValue()} not found.");
    }

    public function findByConfirmToken(string $token): ?User
    {
        return $this->repo->findOneBy(['confirmToken.value' => $token]);
    }

    public function findByResetToken(string $token): ?User
    {
        return $this->repo->findOneBy(['resetToken.value' => $token]);
    }

    public function findByEmail(Email $email): ?User
    {
        return $this->repo->findOneBy(['email' => $email]);
    }
}
