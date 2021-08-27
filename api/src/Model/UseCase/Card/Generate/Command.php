<?php

declare(strict_types=1);

namespace App\Model\UseCase\Card\Generate;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var integer
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @Assert\Positive
     * @Assert\LessThanOrEqual(2000)
     */
    public mixed $count = 0;

    // Setting in controller
    public string $userId = '';
}
