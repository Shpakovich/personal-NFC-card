<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Card\Register;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public mixed $id = '';

    /**
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(min=3, max=100)
     * })
     */
    public mixed $alias = '';

    // Setting in controller
    public string $userId;
}
