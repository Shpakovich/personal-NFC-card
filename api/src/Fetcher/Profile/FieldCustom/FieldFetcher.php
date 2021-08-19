<?php

declare(strict_types=1);

namespace App\Fetcher\Profile\FieldCustom;

use App\Model\Entity\Common\Id;
use Doctrine\DBAL\Connection;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class FieldFetcher
{
    private Connection $connection;
    private DenormalizerInterface $denormalizer;

    public function __construct(Connection $connection, DenormalizerInterface $denormalizer)
    {
        $this->connection = $connection;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @param \App\Model\Entity\Common\Id $profileId
     * @return \App\Fetcher\Profile\FieldCustom\FieldDto[]
     * @throws \Doctrine\DBAL\Exception
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getAllByProfileId(Id $profileId): array
    {
        /** @var \Doctrine\DBAL\ForwardCompatibility\DriverStatement $stmt */
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                [
                    'f.id as id',
                    'f.title as title',
                    'f.bg_color as bg_color',
                    'f.text_color as text_color',
                    'f.icon_path as icon_path',
                    'pf.value as value',
                    'pf.sort as sort',
                ]
            )
            ->from('profiles_fields_custom', 'pf')
            ->innerJoin('pf', 'fields_custom', 'f', 'f.id = pf.field_id')
            ->where('pf.profile_id = :profile_id')
            ->setParameter(':profile_id', $profileId->getValue())
            ->addOrderBy('pf.sort', 'asc')
            ->execute();

        $result = [];
        foreach ($stmt->iterateAssociative() as $row) {
            /** @var \App\Fetcher\Profile\Field\FieldDto */
            $result[] = $this->denormalizer->denormalize($row, FieldDto::class);
        }

        return $result;
    }
}
