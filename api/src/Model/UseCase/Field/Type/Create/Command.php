<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Type\Create;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=1, max=50)
     */
    public mixed $name = '';

    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\PositiveOrZero()
     */
    public mixed $sort = 100;

    // Setting in controller
    public string $id = '';
    public string $userId = '';
}
