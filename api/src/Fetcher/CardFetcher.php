<?php

declare(strict_types=1);

namespace App\Fetcher;

use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class CardFetcher
{
    private Connection $connection;
    private PaginatorInterface $paginator;

    public function __construct(Connection $connection, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
    }

    public function all(int $page, int $limit): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                [
                    'c.id',
                    'c.created_at',
                    'u.id as creator_id',
                    'u.email as creator_email',
                ]
            )
            ->from('cards', 'c')
            ->innerJoin('c', 'users', 'u', 'c.created_by = u.id')
            ->orderBy('c.created_at', 'asc');

        return $this->paginator->paginate($qb, $page, $limit);
    }
}
