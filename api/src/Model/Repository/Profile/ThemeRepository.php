<?php

declare(strict_types=1);

namespace App\Model\Repository\Profile;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Profile\Profile;
use App\Model\Entity\Profile\Theme;
use App\Model\Entity\User\UserCard;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ThemeRepository
{
    private EntityManagerInterface $em;

    /** @var \Doctrine\ORM\EntityRepository<\App\Model\Entity\Profile\Theme> */
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Theme::class);
    }

    public function add(Theme $theme): void
    {
        $this->em->persist($theme);
    }

    public function delete(Theme $theme): void
    {
        $this->em->remove($theme);
    }

    public function getById(Id $id): Theme
    {
        $profile = $this->repo->find($id);
        if ($profile !== null) {
            return $profile;
        }

        throw new \DomainException("Theme '{$id->getValue()}' not found.");
    }

    public function hasByCode(string $code): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->where('t.code = :code')
                ->setParameter(':code', $code)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}
