<?php

declare(strict_types=1);

namespace App\Model\Entity\Field;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fields_types")
 */
class Type
{
    /**
     * @ORM\Id
     * @ORM\Column(type="entity_id")
     */
    private Id $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $name;

    /**
     * @ORM\Column(type="smallint")
     */
    private int $sort;

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

    public function __construct(Id $id, string $name, int $sort, User $creator, \DateTimeImmutable $createdAt)
    {
        $name = trim($name);

        Assert::notEmpty($name);
        Assert::greaterThanEq($sort, 0);

        $this->id = $id;
        $this->name = $name;
        $this->sort = $sort;
        $this->creator = $creator;
        $this->editor = $creator;
        $this->createdAt = $createdAt;
        $this->updatedAt = $createdAt;
    }

    public function getId(): Id
    {
        return $this->id;
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

    public function getSort(): int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;
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
