<?php

declare(strict_types=1);

namespace App\Fetcher\Profile\Field;

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
     * @param null|\App\Model\Entity\Common\Id $typeId
     * @return \App\Fetcher\Profile\Field\FieldDto[]
     * @throws \Doctrine\DBAL\Exception
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getAllByProfileId(Id $profileId, ?Id $typeId = null): array
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                [
                    'ft.id as type_id',
                    'ft.name as type_name',
                    'ft.sort as type_sort',
                    'f.id as id',
                    'f.title as title',
                    'f.bg_color as bg_color',
                    'f.text_color as text_color',
                    'f.icon_path as icon_path',
                    'f.mask as mask',
                    'f.help as help',
                    'pf.value as value',
                    'pf.sort as sort',
                ]
            )
            ->from('profiles_fields', 'pf')
            ->innerJoin('pf', 'fields', 'f', 'f.id = pf.field_id')
            ->innerJoin('f', 'fields_types', 'ft', 'ft.id = f.type_id')
            ->where('pf.profile_id = :profile_id')
            ->setParameter(':profile_id', $profileId->getValue())
            ->orderBy('ft.sort', 'asc')
            ->addOrderBy('pf.sort', 'asc');

        if ($typeId !== null) {
            $qb->andWhere('ft.id = :type_id')
                ->setParameter(':type_id', $typeId->getValue());
        }

        /** @var \Doctrine\DBAL\ForwardCompatibility\DriverStatement $stmt */
        $stmt = $qb->execute();

        $result = [];
        foreach ($stmt->iterateAssociative() as $row) {
            /** @var \App\Fetcher\Profile\Field\FieldDto */
            $result[] = $this->denormalizer->denormalize($row, FieldDto::class);
        }

        return $result;
    }
}
