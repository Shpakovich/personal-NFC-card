<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Reset\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=64)
     * @Assert\Email(mode="html5")
     */
    public string $email = '';
}
