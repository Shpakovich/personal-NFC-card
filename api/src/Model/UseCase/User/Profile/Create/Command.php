<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Profile\Create;

use App\Model\UseCase\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command implements CommandInterface
{
    /**
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Uuid()
     * })
     */
    public mixed $cardId = null;

    /**
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(max=100)
     * })
     */
    public mixed $title = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    public mixed $name = '';

    /**
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(max=100)
     * })
     */
    public mixed $nickname = null;

    /**
     * @Assert\Type(type="int")
     * @Assert\Choice({1, 2}, message="Right values: 1 - name, 2 - nickname")
     */
    public mixed $defaultName = null;

    /**
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(max=100)
     * })
     */
    public mixed $post = null;

    /**
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(max=2000)
     * })
     */
    public mixed $description = null;

    // Setting in controller
    public string $id;
    public string $userId;
}
