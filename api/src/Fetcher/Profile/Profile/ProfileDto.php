<?php

declare(strict_types=1);

namespace App\Fetcher\Profile\Profile;

class ProfileDto
{
    public string $id = '';
    public string $title = '';
    public ?string $photoPath = null;
    public string $name = '';
    public ?string $nickname = null;
    public int $defaultName = 1;
    public ?string $post = null;
    public ?string $description = null;
    public bool $is_published = false;
    public string $userId = '';
    public ?string $userCardId = null;
    public ?string $cardId = null;
    public ?string $cardAlias = null;
}
