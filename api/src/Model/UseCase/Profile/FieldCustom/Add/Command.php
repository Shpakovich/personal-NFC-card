<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\FieldCustom\Add;

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

    // Setting in controller
    public string $id = '';
    public string $userId = '';
}
