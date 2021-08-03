<?php

declare(strict_types=1);

namespace App\Model\Entity\Field\Type;

use App\Model\Entity\Field\Color;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class ColorType extends StringType
{
    private const NAME = 'field_color';

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
        return $value instanceof Color ? $value->getValue() : $value;
    }

    /**
     * @param mixed $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return null|\App\Model\Entity\Field\Color
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Color
    {
        return !empty($value) ? new Color((string)$value) : null;
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
