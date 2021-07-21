<?php

declare(strict_types=1);

namespace App\Model\Entity\User;

use App\Model\Entity\Common\Id;
use Webmozart\Assert\Assert;

class Profile
{
    private const DEFAULT_NAME = 'name';
    private const DEFAULT_NICKNAME = 'nickname';

    private Id $id;
    private User $user;
    private ?UserCard $card = null;
    private string $title;
    private ?string $photoPath = null;
    private string $name;
    private ?string $nickname = null;
    private string $defaultName;
    private ?string $post = null;
    private ?string $description = null;
    private bool $isPublished;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        Id $id,
        User $user,
        string $title,
        string $name,
        string $defaultName,
        \DateTimeImmutable $createdAt
    ) {
        $title = trim($title);
        $name = trim($name);

        Assert::notEmpty($title);
        Assert::notEmpty($name);
        Assert::isAnyOf($defaultName, [
            self::DEFAULT_NAME,
            self::DEFAULT_NICKNAME,
        ]);

        $this->id = $id;
        $this->user = $user;
        $this->title = $title;
        $this->name = $name;
        $this->defaultName = $defaultName;
        $this->createdAt = $createdAt;
        $this->updatedAt = $createdAt;
        $this->isPublished = false;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCard(): ?UserCard
    {
        return $this->card;
    }

    public function setCard(?UserCard $card): self
    {
        $this->card = $card;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getPhotoPath(): ?string
    {
        return $this->photoPath;
    }

    public function setPhotoPath(?string $photoPath): self
    {
        $this->photoPath = $photoPath;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;
        return $this;
    }

    public function getDefaultName(): string
    {
        return $this->defaultName;
    }

    public function setDefaultName(string $defaultName): self
    {
        $this->defaultName = $defaultName;
        return $this;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(?string $post): self
    {
        $this->post = $post;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
