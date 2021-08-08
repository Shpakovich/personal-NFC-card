<?php

declare(strict_types=1);

namespace App\Fetcher\User;

use Doctrine\DBAL\Connection;

class CardFetcher
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
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
