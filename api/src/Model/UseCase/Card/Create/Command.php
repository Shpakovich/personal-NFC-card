<?php

declare(strict_types=1);

namespace App\Model\UseCase\Card\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $id = '';

    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }
}
