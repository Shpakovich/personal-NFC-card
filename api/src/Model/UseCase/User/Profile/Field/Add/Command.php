<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Profile\Field\Add;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public mixed $profileId = '';

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public mixed $fieldId = '';

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    public mixed $value = '';

    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Type(type="int")
     * @Assert\Positive()
     */
    public mixed $sort = 10;

    // Setting in controller
    public string $id = '';
    public string $userId = '';
}
