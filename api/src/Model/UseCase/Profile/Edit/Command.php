<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Edit;

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
     * @Assert\Length(max=100)
     */
    public mixed $title = '';

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    public mixed $name = '';

    /**
     * @var string
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(max=100)
     * })
     */
    public mixed $nickname = '';

    /**
     * @var int
     * @Assert\Type(type="int")
     * @Assert\Choice({1, 2}, message="Right values: 1 - name, 2 - nickname")
     */
    public mixed $defaultName = 1;

    /**
     * @var string
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(max=100)
     * })
     */
    public mixed $post = '';

    /**
     * @var string
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(max=2000)
     * })
     */
    public mixed $description = '';

    // Setting in controller
    public string $userId = '';
}
