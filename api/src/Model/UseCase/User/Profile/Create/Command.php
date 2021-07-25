<?php

declare(strict_types=1);

namespace App\Model\UseCase\User\Profile\Create;

use App\Model\Entity\User\Profile;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $userId;

    /**
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Uuid()
     * })
     */
    public ?string $cardId = null;

    /**
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(max=100)
     * })
     */
    public ?string $title = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    public string $name = '';

    /**
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(max=100)
     * })
     */
    public ?string $nickname = null;

    /**
     * @Assert\Type(type="int")
     * @Assert\Choice({1, 2}, message="Right values: 1 - name, 2 - nickname")
     */
    public int $defaultName = Profile::DEFAULT_NAME;

    /**
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(max=100)
     * })
     */
    public ?string $post = null;

    /**
     * @Assert\AtLeastOneOf({
     *     @Assert\Blank(),
     *     @Assert\Length(max=2000)
     * })
     */
    public ?string $description = null;

    public function __construct(string $id, string $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }
}
