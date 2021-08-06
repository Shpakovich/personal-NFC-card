<?php

declare(strict_types=1);

namespace App\Fetcher\User;

use Doctrine\DBAL\Connection;

class ProfileFetcher
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getOneByFilter(Filter $filter): ?array
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                [
                    'p.id',
                    'p.title',
                    'p.photo_path',
                    'p.name',
                    'p.nickname',
                    'p.default_name',
                    'p.post',
                    'p.description',
                    'p.is_published',
                    'p.user_id',
                    'uc.card_id',
                    'uc.alias as card_alias',
                ]
            )
            ->from('user_cards', 'uc')
            ->innerJoin('uc', 'profiles', 'p', 'uc.id = p.user_card_id')
            ->setMaxResults(1);

        $identity = $filter->getIdentity();
        if ($identity !== null) {
            if (preg_match('/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/', $identity)) {
                $qb->andWhere('uc.card_id = :identity');
            } else {
                $qb->andWhere('uc.alias = :identity');
            }

            $qb->setParameter(':identity', $identity);
        }

        if ($filter->isOnlyPublished()) {
            $qb->andWhere('p.is_published = true');
        }

        $result = $qb
            ->execute()
            ->fetchAssociative();

        if ($result !== false) {
            return $result;
        }

        throw new \DomainException('Card not found');
    }
}
