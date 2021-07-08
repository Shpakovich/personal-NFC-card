<?php

declare(strict_types=1);

namespace App\Model\Entity\User\Type;

use App\Model\Entity\User\Status;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\SmallIntType;

class StatusType extends SmallIntType
{
    public const NAME = 'user_status';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param mixed $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Status ? $value->getValue() : $value;
    }

    /**
     * @param mixed $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return null|\App\Model\Entity\User\Status
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Status
    {
        return !empty($value) ? new Status((int)$value) : null;
    }

    /**
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
