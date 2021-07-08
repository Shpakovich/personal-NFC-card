<?php

declare(strict_types=1);

namespace App\Model\Entity\User\Type;

use App\Model\Entity\User\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class IdType extends GuidType
{
    private const NAME = 'user_id';

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
        return $value instanceof Id ? $value->getValue() : $value;
    }

    /**
     * @param mixed $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return null|\App\Model\Entity\User\Id
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Id
    {
        return !empty($value) ? new Id((string)$value) : null;
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
