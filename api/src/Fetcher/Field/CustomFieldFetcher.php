<?php

declare(strict_types=1);

namespace App\Fetcher\Field;

use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class CustomFieldFetcher
{
    private Connection $connection;
    private PaginatorInterface $paginator;

    public function __construct(Connection $connection, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
    }

    public function all(int $page, int $limit, ?string $userId = null): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                [
                    'f.id',
                    'f.title',
                    'f.bg_color',
                    'f.text_color',
                    'f.icon_path',
                    'f.created_at',
                    'f.updated_at',
                    'u.id as user_id',
                    'u.email as user_email',
                ]
            )
            ->from('fields_custom', 'f')
            ->innerJoin('f', 'users', 'u', 'f.user_id = u.id');

        if ($userId !== null) {
            $qb->andWhere('f.user_id = :user_id')
                ->setParameter(':user_id', $userId);
        }

        return $this->paginator->paginate($qb, $page, $limit);
    }
}
