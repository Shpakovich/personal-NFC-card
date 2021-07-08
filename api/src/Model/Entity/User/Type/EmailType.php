<?php

declare(strict_types=1);

namespace App\Model\Entity\User\Type;

use App\Model\Entity\User\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EmailType extends StringType
{
    public const NAME = 'user_email';

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
        return $value instanceof Email ? $value->getValue() : $value;
    }

    /**
     * @param mixed $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return null|\App\Model\Entity\User\Email
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        return !empty($value) ? new Email((string)$value) : null;
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
