<?php

declare(strict_types=1);

namespace App\Fetcher\Profile;

use App\Model\Entity\Common\Id;
use Doctrine\DBAL\Connection;

class FieldFetcher
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getAllByProfileId(Id $profileId): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                [
                    'ft.id as field_type_id',
                    'ft.name as field_type_name',
                    'ft.sort as field_type_sort',
                    'f.id as field_id',
                    'f.title as field_title',
                    'f.bg_color as field_bg_color',
                    'f.text_color as field_text_color',
                    'f.icon_path as field_icon_path',
                    'f.help as field_help',
                    'pf.value as field_value',
                    'pf.sort as field_sort',
                ]
            )
            ->from('profiles_fields', 'pf')
            ->innerJoin('pf', 'fields', 'f', 'f.id = pf.field_id')
            ->innerJoin('f', 'fields_types', 'ft', 'ft.id = f.type_id')
            ->where('pf.profile_id = :profile_id')
            ->setParameter(':profile_id', $profileId->getValue())
            ->orderBy('ft.sort', 'asc')
            ->addOrderBy('pf.sort', 'asc')
            ->execute();

        return $stmt->fetchAllAssociative();
    }
}
