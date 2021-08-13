<?php

declare(strict_types=1);

namespace App\Fetcher\User;

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

    public function all(int $page, int $limit, ?string $userId = null): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                [
                    'uc.id',
                    'uc.card_id',
                    'uc.alias',
                    'uc.added_at',
                    'u.id as user_id',
                    'u.email as user_email',
                ]
            )
            ->from('user_cards', 'uc')
            ->innerJoin('uc', 'users', 'u', 'uc.user_id = u.id');

        if ($userId !== null) {
            $qb->andWhere('uc.user_id = :user_id')
                ->setParameter(':user_id', $userId);
        }

        return $this->paginator->paginate($qb, $page, $limit);
    }

    public function findByIdentity(string $identity): ?array
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                [
                    'uc.id',
                    'uc.card_id',
                    'uc.alias',
                ]
            )
            ->from('user_cards', 'uc')
            ->setMaxResults(1);

        if (preg_match('/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/', $identity)) {
            $qb->where('uc.card_id = :identity');
        } else {
            $qb->where('uc.alias = :identity');
        }

        /** @var \Doctrine\DBAL\ForwardCompatibility\DriverStatement $stmt */
        $stmt = $qb
            ->setParameter(':identity', $identity)
            ->execute();

        $result = $stmt->fetchAssociative();

        return $result !== false ? $result : null;
    }
}
