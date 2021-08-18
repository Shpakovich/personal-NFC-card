<?php

declare(strict_types=1);

namespace App\Model\UseCase\Field\Custom\Edit;

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
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=1, max=50)
     */
    public mixed $title = '';

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^#[\da-fA-F]{3,6}$/")
     * @Assert\Length(min=1, max=7)
     */
    public mixed $bgColor = '';

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^#[\da-fA-F]{3,6}$/")
     * @Assert\Length(min=1, max=7)
     */
    public mixed $textColor = '';

    // Setting in controller
    public string $userId = '';
}
