<?php

declare(strict_types=1);

namespace App\Model\Entity\Field;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fields_custom")
 */
class CustomField
{
    /**
     * @ORM\Id
     * @ORM\Column(type="entity_id")
     */
    private Id $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\User\User", inversedBy="fields")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="RESTRICT", nullable=false)
     */
    private User $user;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $title;

    /**
     * @ORM\Column(type="field_color", length=7)
     */
    private Color $bgColor;

    /**
     * @ORM\Column(type="field_color", length=7)
     */
    private Color $textColor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $iconPath = null;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        Id $id,
        User $user,
        string $title,
        Color $bgColor,
        Color $textColor,
        \DateTimeImmutable $createdAt
    ) {
        $title = trim($title);

        Assert::notEmpty($title);

        $this->id = $id;
        $this->user = $user;
        $this->title = $title;
        $this->bgColor = $bgColor;
        $this->textColor = $textColor;
        $this->createdAt = $createdAt;
        $this->updatedAt = $createdAt;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getBgColor(): Color
    {
        return $this->bgColor;
    }

    public function setBgColor(Color $bgColor): self
    {
        $this->bgColor = $bgColor;
        return $this;
    }

    public function getTextColor(): Color
    {
        return $this->textColor;
    }

    public function setTextColor(Color $textColor): self
    {
        $this->textColor = $textColor;
        return $this;
    }

    public function getIconPath(): ?string
    {
        return $this->iconPath;
    }

    public function setIconPath(string $iconPath): self
    {
        $this->iconPath = $iconPath;
        return $this;
    }

    public function removeIconPath(): self
    {
        $this->iconPath = null;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
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
