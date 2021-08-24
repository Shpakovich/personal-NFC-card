<?php

declare(strict_types=1);

namespace App\Model\Entity\User;

use App\Model\Entity\Common\Id;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="users",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="users_confirm_token_value_uidx", columns={"confirm_token_value"}),
 *          @ORM\UniqueConstraint(name="users_reset_token_value_uidx", columns={"reset_token_value"})
 *     },
 *     indexes={
 *          @ORM\Index(name="users_status_idx", columns={"status"})
 *     }
 * )
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="entity_id")
     */
    private Id $id;

    /**
     * @ORM\Column(type="user_email", length=64)
     */
    private Email $email;

    /**
     * @ORM\Embedded(class="Token")
     */
    private ?Token $confirmToken = null;

    /**
     * @ORM\Embedded(class="Token")
     */
    private ?Token $resetToken = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $passwordHash;

    /**
     * @ORM\Column(type="user_status")
     */
    private Status $status;

    /**
     * @ORM\Column(type="user_role", length=16)
     */
    private Role $role;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $updatedAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $lastAuthAt = null;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Entity\User\UserCard",
     *     mappedBy="user", orphanRemoval=true, cascade={"all"}
     * )
     */
    private ArrayCollection|PersistentCollection $cards;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Entity\Profile\Profile",
     *     mappedBy="user", cascade={"all"}
     * )
     */
    private ArrayCollection|PersistentCollection $profiles;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Entity\Field\CustomField",
     *     mappedBy="user", cascade={"all"}
     * )
     */
    private ArrayCollection|PersistentCollection $fields;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Entity\User\Favorite",
     *     mappedBy="user", cascade={"all"}
     * )
     */
    private ArrayCollection|PersistentCollection $favorite;

    public function __construct(
        Id $id,
        Email $email,
        string $passwordHash,
        ?Token $confirmToken,
        Role $role,
        \DateTimeImmutable $createdAt
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->confirmToken = $confirmToken;
        $this->role = $role;
        $this->createdAt = $createdAt;
        $this->updatedAt = $createdAt;
        $this->status = Status::wait();

        $this->cards = new ArrayCollection();
        $this->profiles = new ArrayCollection();
        $this->fields = new ArrayCollection();
        $this->favorite = new ArrayCollection();
    }

    public function confirm(\DateTimeImmutable $data): void
    {
        if ($this->status->isActive()) {
            throw new \DomainException('User already is active.');
        }

        $this->status = Status::active();
        $this->confirmToken = null;
        $this->updatedAt = $data;
    }

    public function block(\DateTimeImmutable $data): void
    {
        if ($this->status->isBlock()) {
            throw new \DomainException('User already is block.');
        }

        $this->status = Status::block();
        $this->updatedAt = $data;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getConfirmToken(): ?Token
    {
        return $this->confirmToken;
    }

    public function setConfirmToken(Token $confirmToken): User
    {
        $this->confirmToken = $confirmToken;
        return $this;
    }

    public function getResetToken(): ?Token
    {
        return $this->resetToken;
    }

    public function setResetToken(Token $resetToken): User
    {
        $this->resetToken = $resetToken;
        return $this;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): User
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): User
    {
        $this->status = $status;
        return $this;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): User
    {
        $this->role = $role;
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

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): User
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getLastAuthAt(): ?\DateTimeImmutable
    {
        return $this->lastAuthAt;
    }

    public function setLastAuthAt(\DateTimeImmutable $lastAuthAt): User
    {
        $this->lastAuthAt = $lastAuthAt;
        return $this;
    }

    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function getProfiles(): Collection
    {
        return $this->profiles;
    }

    public function getFavorite(): ArrayCollection|PersistentCollection
    {
        return $this->favorite;
    }

    public function addFavorite(Favorite $favorite): User
    {
        $this->favorite->add($favorite);
        return $this;
    }
}
