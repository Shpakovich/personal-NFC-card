<?php

declare(strict_types=1);

namespace App\Fetcher\User;

use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class FavoriteFetcher
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
                    'u.id as user_id',
                    'u.email as user_email',
                    'p.id as profile_id',
                    'p.name as profile_name',
                    'p.nickname as profile_nickname',
                    'p.default_name as profile_default_name',
                    'p.post as profile_post',
                    'p.photo_path as profile_photo_path',
                    'uc.card_id as card_id',
                    'uc.alias as card_alias'
                ]
            )
            ->from('favorites', 'f')
            ->innerJoin('f', 'users', 'u', 'f.user_id = u.id')
            ->innerJoin('f', 'profiles', 'p', 'f.profile_id = p.id')
            ->innerJoin('u', 'user_cards', 'uc', 'p.user_id = uc.user_id');

        if ($userId !== null) {
            $qb->andWhere('f.user_id = :user_id')
                ->setParameter(':user_id', $userId);
        }

        return $this->paginator->paginate($qb, $page, $limit);
    }
}
