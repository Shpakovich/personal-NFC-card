<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Field\Icon\Add;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
