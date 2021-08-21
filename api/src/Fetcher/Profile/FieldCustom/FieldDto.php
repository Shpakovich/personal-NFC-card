<?php

declare(strict_types=1);

namespace App\Fetcher\Profile\FieldCustom;

class FieldDto
{
    public string $id = '';
    public string $title = '';
    public string $bgColor = '';
    public string $textColor = '';
    public ?string $iconPath = null;
    public string $value = '';
    public int $sort = 10;
}
