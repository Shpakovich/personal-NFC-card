<?php

declare(strict_types=1);

namespace App\Model\Entity\Profile;

use App\Model\Entity\Common\Id;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="profiles_fields_custom")
 */
class CustomField
{
    /**
     * @ORM\Id
     * @ORM\Column(type="entity_id")
     */
    private Id $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\Profile\Profile", inversedBy="customFields")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="RESTRICT", nullable=false)
     */
    private Profile $profile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\Field\CustomField")
     * @ORM\JoinColumn(name="field_id", referencedColumnName="id", onDelete="RESTRICT", nullable=true)
     */
    private \App\Model\Entity\Field\CustomField $field;

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
        \App\Model\Entity\Field\CustomField $field,
        string $value
    ) {
        $value = trim($value);
        Assert::notEmpty($value);

        $this->id = $id;
        $this->profile = $profile;
        $this->field = $field;
        $this->value = $value;
        $this->sort = $profile->getCustomFields()->count() + 1;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function getField(): \App\Model\Entity\Field\CustomField
    {
        return $this->field;
    }

    public function setField(\App\Model\Entity\Field\CustomField $field): self
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

    public function sortIncrease(): self
    {
        ++$this->sort;
        return $this;
    }

    public function sortDecrease(): self
    {
        --$this->sort;
        return $this;
    }
}
