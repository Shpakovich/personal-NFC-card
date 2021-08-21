<?php

declare(strict_types=1);

namespace App\Model\Repository\Metric;

use App\Model\Entity\Metric\View;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ViewRepository
{
    private EntityManagerInterface $em;

    /** @var \Doctrine\ORM\EntityRepository<\App\Model\Entity\Metric\View> */
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(View::class);
    }

    public function add(View $view): void
    {
        $this->em->persist($view);
    }
}
