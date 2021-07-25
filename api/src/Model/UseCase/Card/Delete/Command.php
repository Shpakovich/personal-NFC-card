<?php

declare(strict_types=1);

namespace App\Model\UseCase\Card\Delete;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public mixed $id = '';
}
