<?php

declare(strict_types=1);

namespace App\Fetcher\Metric\View;

use Doctrine\DBAL\Connection;

class ViewFetcher
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function forPeriodByProfileId(
        string $profileId,
        ?\DateTimeImmutable $from = null,
        ?\DateTimeImmutable $to = null
    ): int {
        $qb = $this->connection->createQueryBuilder()
            ->select('count(\'mv.profile_id\')')
            ->from('metrics_views', 'mv')
            ->where('mv.profile_id = :profile_id')
            ->setParameter(':profile_id', $profileId);

        if ($from !== null && $to !== null) {
            $qb->andWhere('mv.created_at BETWEEN :from AND :to')
                ->setParameter(':from', $from->format('Y-m-d H:i:s'))
                ->setParameter(':to', $to->format('Y-m-d H:i:s'));
        }

        /** @var \Doctrine\DBAL\ForwardCompatibility\DriverResultStatement $stmt */
        $stmt = $qb->execute();
        /** @var int[]|false $result */
        $result = $stmt->fetchNumeric();

        return is_array($result) && count($result) > 0 ? reset($result) : 0;
    }
}
