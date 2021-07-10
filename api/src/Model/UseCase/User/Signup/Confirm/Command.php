<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Signup\Confirm;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    public string $token = '';
}
