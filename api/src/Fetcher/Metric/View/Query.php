<?php

declare(strict_types=1);

namespace App\Fetcher\Metric\View;

use Symfony\Component\Validator\Constraints as Assert;

class Query
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public mixed $profileId = '';

    public \DateTimeImmutable|null $from = null;
    public \DateTimeImmutable|null $to = null;
}
