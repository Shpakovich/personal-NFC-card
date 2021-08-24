<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\Favorite;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class FavoriteRepository
{
    private EntityManagerInterface $em;

    /** @var \Doctrine\ORM\EntityRepository<\App\Model\Entity\User\Favorite> */
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Favorite::class);
    }

    public function add(Favorite $favorite): void
    {
        $this->em->persist($favorite);
    }

    public function delete(Favorite $favorite): void
    {
        $this->em->remove($favorite);
    }

    public function getById(Id $id): Favorite
    {
        $user = $this->repo->find($id);
        if ($user !== null) {
            return $user;
        }

        throw new \DomainException("Favorite profile not found.");
    }
}
