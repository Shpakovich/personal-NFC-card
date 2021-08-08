<?php

declare(strict_types=1);

namespace App\Model\Entity\User\Profile;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\Field as FieldEntity;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="profiles_fields")
 */
class Field
{
    /**
     * @ORM\Id
     * @ORM\Column(type="entity_id")
     */
    private Id $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\User\Profile\Profile", inversedBy="fields")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="RESTRICT", nullable=false)
     */
    private Profile $profile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\Field\Field")
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id", onDelete="RESTRICT", nullable=true)
     */
    private FieldEntity $field;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $value;

    /**
     * @ORM\Column(type="smallint", options={"default": 10})
     */
    private int $sort;

    public function __construct(
        Id $id,
        Profile $profile,
        FieldEntity $field,
        string $value,
        int $sort
    ) {
        $value = trim($value);

        Assert::notEmpty($value);
        Assert::positiveInteger($sort);

        $this->id = $id;
        $this->profile = $profile;
        $this->field = $field;
        $this->value = $value;
        $this->sort = $sort;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function getField(): FieldEntity
    {
        return $this->field;
    }

    public function setField(FieldEntity $field): self
    {
        $this->field = $field;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;
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
}
