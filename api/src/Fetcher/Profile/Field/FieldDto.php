<?php

declare(strict_types=1);

namespace App\Fetcher\Profile\Field;

class FieldDto
{
    public string $typeId = '';
    public string $typeName = '';
    public int $typeSort = 10;
    public string $id = '';
    public string $title = '';
    public string $bgColor = '';
    public string $textColor = '';
    public ?string $iconPath = null;
    public ?string $help = null;
    public string $value = '';
    public int $sort = 10;
}
