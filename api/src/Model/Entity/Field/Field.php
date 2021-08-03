<?php

declare(strict_types=1);

namespace App\Model\Entity\Field;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fields")
 */
class Field
{
    /**
     * @ORM\Id
     * @ORM\Column(type="entity_id")
     */
    private Id $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\Field\Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="RESTRICT", nullable=false)
     */
    private Type $type;

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
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private ?string $help = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\User\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", onDelete="RESTRICT", nullable=false)
     */
    private User $creator;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\User\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", onDelete="RESTRICT", nullable=false)
     */
    private User $editor;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        Id $id,
        string $title,
        Type $type,
        Color $bgColor,
        Color $textColor,
        User $creator,
        \DateTimeImmutable $createdAt
    ) {
        $title = trim($title);

        Assert::notEmpty($title);

        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->bgColor = $bgColor;
        $this->textColor = $textColor;
        $this->creator = $creator;
        $this->editor = $creator;
        $this->createdAt = $createdAt;
        $this->updatedAt = $createdAt;
    }

    public function getId(): Id
    {
        return $this->id;
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

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): self
    {
        $this->type = $type;
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

    public function setIconPath(?string $iconPath): self
    {
        $this->iconPath = $iconPath;
        return $this;
    }

    public function getHelp(): ?string
    {
        return $this->help;
    }

    public function setHelp(?string $help): self
    {
        Assert::notEmpty($help);

        $this->help = $help;
        return $this;
    }

    public function getCreator(): User
    {
        return $this->creator;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getEditor(): User
    {
        return $this->editor;
    }

    public function setEditor(User $editor): self
    {
        $this->editor = $editor;
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
