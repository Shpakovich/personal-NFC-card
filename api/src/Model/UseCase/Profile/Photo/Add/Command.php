<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Photo\Add;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @psalm-suppress MissingConstructor
 */
class Command implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public mixed $profileId = '';

    // Setting in controller
    public File $file;
    public string $userId = '';
}
