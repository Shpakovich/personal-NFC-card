<?php

declare(strict_types=1);

namespace App\Model\UseCase\Card\Create;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public mixed $id = '';

    // Setting in controller
    public string $userId;
}
