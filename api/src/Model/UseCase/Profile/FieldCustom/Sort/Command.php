<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\FieldCustom\Sort;

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

    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Type(type="int")
     * @Assert\Positive()
     */
    public mixed $sort = 1;

    /** Setting in controller */
    public string $userId = '';
}
