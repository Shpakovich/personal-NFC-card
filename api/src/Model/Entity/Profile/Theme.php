<?php

declare(strict_types=1);

namespace App\Model\Entity\Profile;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\Field as FieldEntity;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="themes", uniqueConstraints={
 *          @ORM\UniqueConstraint(name="themes_code_uidx", columns={"code"}),
 *     })
 */
class Theme
{
    /**
     * @ORM\Id
     * @ORM\Column(type="entity_id")
     */
    private Id $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private string $code;

    public function __construct(
        Id $id,
        string $name,
        string $code
    ) {
        $name = trim($name);
        $code = trim($code);

        Assert::notEmpty($name);
        Assert::notEmpty($code);
        Assert::regex($code, '/^[\da-zA-Z\-_]+$/');

        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Theme
    {
        $this->name = $name;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): Theme
    {
        $this->code = $code;
        return $this;
    }
}
