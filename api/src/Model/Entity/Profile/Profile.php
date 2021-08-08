<?php

declare(strict_types=1);

namespace App\Model\Entity\Profile;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\User;
use App\Model\Entity\User\UserCard;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="profiles", uniqueConstraints={
 *          @ORM\UniqueConstraint(name="profile_user_id_user_card_id_uidx", columns={"user_id", "user_card_id"})
 *     })
 */
class Profile
{
    public const DEFAULT_NAME = 1;
    public const DEFAULT_NICKNAME = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="entity_id")
     */
    private Id $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\User\User", inversedBy="profiles")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="RESTRICT", nullable=false)
     */
    private User $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Model\Entity\User\UserCard")
     * @ORM\JoinColumn(name="user_card_id", referencedColumnName="id", onDelete="RESTRICT", nullable=true)
     */
    private ?UserCard $card = null;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $photoPath = null;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $nickname = null;

    /**
     * @ORM\Column(type="smallint",  options={"default": Profile::DEFAULT_NAME})
     */
    private int $defaultName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $post = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private bool $isPublished;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $updatedAt;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Entity\Profile\Field",
     *     mappedBy="profile", cascade={"all"}
     * )
     */
    private ArrayCollection|PersistentCollection $fields;

    public function __construct(
        Id $id,
        User $user,
        string $title,
        string $name,
        int $defaultName,
        \DateTimeImmutable $createdAt
    ) {
        $title = trim($title);
        $name = trim($name);

        Assert::notEmpty($title);
        Assert::notEmpty($name);
        Assert::oneOf($defaultName, [
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

        $this->fields = new ArrayCollection();
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

    public function getDefaultName(): int
    {
        return $this->defaultName;
    }

    public function setDefaultName(int $defaultName): self
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
        return $this->isPublished === true;
    }

    public function isHidden(): bool
    {
        return $this->isPublished === false;
    }

    public function publish(): self
    {
        $this->isPublished = true;
        return $this;
    }

    public function hide(): self
    {
        $this->isPublished = false;
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

    public function addField(Field $field): self
    {
        $this->fields->add($field);
        return $this;
    }
}
