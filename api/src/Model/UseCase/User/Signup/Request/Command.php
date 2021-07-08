<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Signup\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=64)
     * @Assert\Email(mode="html5")
     */
    public string $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     */
    public string $password;
}
