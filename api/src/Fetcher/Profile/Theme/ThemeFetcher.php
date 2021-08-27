<?php

declare(strict_types=1);

namespace App\Fetcher\Profile\Theme;

use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class ThemeFetcher
{
    private Connection $connection;
    private PaginatorInterface $paginator;

    public function __construct(Connection $connection, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
    }

    /**
     * @param int $page
     * @param int $limit
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function all(int $page, int $limit): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                [
                    't.id',
                    't.name',
                    't.code',
                ]
            )
            ->from('themes', 't');

        return $this->paginator->paginate($qb, $page, $limit);
    }
}
