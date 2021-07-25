<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Signup\Request;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=64)
     * @Assert\Email(mode="html5")
     */
    public mixed $email = '';

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     */
    public mixed $password = '';
}
