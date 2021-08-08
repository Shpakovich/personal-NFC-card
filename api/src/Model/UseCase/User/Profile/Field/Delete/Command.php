<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Profile\Field\Delete;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public mixed $id = '';

    /** Setting in controller */
    public string $userId = '';
}
