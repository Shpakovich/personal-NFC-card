<?php

declare(strict_types=1);

namespace App\Fetcher\Field;

use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class TypeFetcher
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
                    'ft.id',
                    'ft.name',
                    'ft.sort',
                    'ft.created_at',
                    'ft.updated_at',
                    'uc.id as creator_id',
                    'uc.email as creator_email',
                    'uu.id as editor_id',
                    'uu.email as editor_email',
                ]
            )
            ->from('fields_types', 'ft')
            ->innerJoin('ft', 'users', 'uc', 'ft.created_by = uc.id')
            ->innerJoin('ft', 'users', 'uu', 'ft.updated_by = uu.id')
            ->orderBy('ft.sort', 'asc');

        return $this->paginator->paginate($qb, $page, $limit);
    }
}
