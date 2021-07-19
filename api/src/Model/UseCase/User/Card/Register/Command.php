<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Card\Register;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $id = '';

    /**
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(min=3, max=100)
     * })
     */
    public string $alias = '';

    /**
     * @Assert\NotBlank()
     */
    public string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }
}
