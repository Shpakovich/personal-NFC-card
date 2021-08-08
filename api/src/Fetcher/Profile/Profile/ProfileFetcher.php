<?php

declare(strict_types=1);

namespace App\Fetcher\Profile\Profile;

use App\Fetcher\User\Filter;
use Doctrine\DBAL\Connection;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ProfileFetcher
{
    private Connection $connection;
    private DenormalizerInterface $denormalizer;

    public function __construct(Connection $connection, DenormalizerInterface $denormalizer)
    {
        $this->connection = $connection;
        $this->denormalizer = $denormalizer;
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

        /** @var \Doctrine\DBAL\ForwardCompatibility\DriverStatement $stmt */
        $stmt = $qb->execute();
        $result = $stmt->fetchAssociative();

        if ($result !== false) {
            /** @var \App\Fetcher\Profile\Profile\ProfileDto */
            return $this->denormalizer->denormalize($result, ProfileDto::class);
        }

        throw new \DomainException('Card not found');
    }
}
