<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Theme\Delete;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public mixed $id = '';
}
