<?php

declare(strict_types=1);

namespace App\Fetcher\Profile\Profile;

use App\Fetcher\User\Filter;
use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ProfileFetcher
{
    private Connection $connection;
    private DenormalizerInterface $denormalizer;
    private PaginatorInterface $paginator;

    public function __construct(
        Connection $connection,
        DenormalizerInterface $denormalizer,
        PaginatorInterface $paginator
    ) {
        $this->connection = $connection;
        $this->denormalizer = $denormalizer;
        $this->paginator = $paginator;
    }

    /**
     * @param \App\Fetcher\User\Filter $filter
     * @return \App\Fetcher\Profile\Profile\ProfileDto
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getOneByFilter(Filter $filter): ProfileDto
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
                    'uc.id as user_card_id',
                    'uc.card_id',
                    'uc.alias as card_alias',
                    't.id as theme_id',
                    't.name as theme_name',
                    't.code as theme_code',
                ]
            )
            ->from('user_cards', 'uc')
            ->innerJoin('uc', 'profiles', 'p', 'uc.id = p.user_card_id')
            ->leftJoin('p', 'themes', 't', 'p.theme_id = t.id')
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

        /** @var \Doctrine\DBAL\ForwardCompatibility\DriverStatement $stmt */
        $stmt = $qb->execute();
        $result = $stmt->fetchAssociative();

        if ($result !== false) {
            /** @var \App\Fetcher\Profile\Profile\ProfileDto */
            return $this->denormalizer->denormalize($result, ProfileDto::class);
        }

        throw new \DomainException('Card not found');
    }

    public function all(int $page, int $limit, ?string $userId = null): PaginationInterface
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
                    'p.created_at',
                    'p.updated_at',
                    'uc.card_id',
                    'uc.alias as card_alias',
                    'u.id as user_id',
                    'u.email as user_email',
                    't.id as theme_id',
                    't.name as theme_name',
                    't.code as theme_code',
                ]
            )
            ->from('profiles', 'p')
            ->leftJoin('p', 'user_cards', 'uc', 'uc.id = p.user_card_id')
            ->leftJoin('p', 'themes', 't', 'p.theme_id = t.id')
            ->innerJoin('p', 'users', 'u', 'p.user_id = u.id');

        if ($userId !== null) {
            $qb->andWhere('p.user_id = :user_id')
                ->setParameter(':user_id', $userId);
        }

        return $this->paginator->paginate($qb, $page, $limit);
    }
}
