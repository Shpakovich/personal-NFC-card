<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Custom\Icon\Add;

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
    public mixed $fieldId = '';

    // Setting in controller
    public Icon $icon;
    public string $userId = '';
}
