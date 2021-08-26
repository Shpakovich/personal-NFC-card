<?php

declare(strict_types=1);

namespace App\Model\UseCase\Theme\Create;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    public mixed $name = '';

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=15)
     * @Assert\Regex(pattern="/^[\da-zA-Z\-_]+$/")
     */
    public mixed $code = '';

    // Setting in controller
    public string $id = '';
}
