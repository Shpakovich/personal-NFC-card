<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Reset\Confirm;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    public string $token = '';

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     */
    public string $password = '';
}
