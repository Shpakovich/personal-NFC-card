<?php

declare(strict_types=1);

namespace App\Fetcher\Field;

use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class FieldFetcher
{
    private Connection $connection;
    private PaginatorInterface $paginator;

    public function __construct(Connection $connection, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
    }

    public function all(int $page, int $limit, ?string $typeId = null): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                [
                    'f.id',
                    'f.title',
                    'f.bg_color',
                    'f.text_color',
                    'f.icon_path',
                    'f.help',
                    'f.created_at',
                    'f.updated_at',
                    'ft.id as type_id',
                    'ft.name as type_name',
                    'ft.sort as type_sort',
                    'uc.id as creator_id',
                    'uc.email as creator_email',
                    'uu.id as editor_id',
                    'uu.email as editor_email',
                ]
            )
            ->from('fields', 'f')
            ->innerJoin('f', 'fields_types', 'ft', 'f.type_id = ft.id')
            ->innerJoin('f', 'users', 'uc', 'f.created_by = uc.id')
            ->innerJoin('f', 'users', 'uu', 'f.updated_by = uu.id')
            ->orderBy('ft.sort', 'asc');

        if ($typeId !== null) {
            $qb->where('ft.id = :type_id')
                ->setParameter(':type_id', $typeId);
        }

        return $this->paginator->paginate($qb, $page, $limit);
    }
}
