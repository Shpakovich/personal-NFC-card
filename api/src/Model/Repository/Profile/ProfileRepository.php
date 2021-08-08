<?php

declare(strict_types=1);

namespace App\Model\Repository\Profile;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Profile\Profile;
use App\Model\Entity\User\UserCard;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ProfileRepository
{
    private EntityManagerInterface $em;

    /** @var \Doctrine\ORM\EntityRepository<\App\Model\Entity\Profile\Profile> */
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repo = $em->getRepository(Profile::class);
    }

    public function add(Profile $profile): void
    {
        $this->em->persist($profile);
    }

    public function delete(Profile $profile): void
    {
        $this->em->remove($profile);
    }

    public function getById(Id $id): Profile
    {
        $profile = $this->repo->find($id);
        if ($profile !== null) {
            return $profile;
        }

        throw new \DomainException("Profile {$id->getValue()} not found.");
    }

    public function hasByCard(UserCard $card): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->where('t.card = :card')
                ->setParameter(':card', $card)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}
