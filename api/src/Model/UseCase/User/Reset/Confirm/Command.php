<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Reset\Confirm;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    public mixed $token = '';

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     */
    public mixed $password = '';
}
