<?php

declare(strict_types=1);

namespace App\Model\Entity\UserCard;

use App\Model\Entity\Card\Card;
use App\Model\Entity\Common\Id;
use App\Model\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_cards", uniqueConstraints={
 *          @ORM\UniqueConstraint(name="user_cards_card_id_uidx", columns={"card_id"}),
 *          @ORM\UniqueConstraint(name="user_cards_alias_uidx", columns={"alias"}),
 *     })
 */
class UserCard
{
    /**
     * @ORM\Id
     * @ORM\Column(type="entity_id")
     */
    private Id $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\User\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="RESTRICT", nullable=false)
     */
    private User $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Model\Entity\Card\Card", inversedBy="owner")
     * @ORM\JoinColumn(name="card_id", referencedColumnName="id", onDelete="RESTRICT", nullable=false)
     */
    private Card $card;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $alias;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $addedAt;

    public function __construct(Id $id, User $user, Card $card, \DateTimeImmutable $createdAt, ?string $alias = null)
    {
        $this->id = $id;
        $this->user = $user;
        $this->card = $card;
        $this->addedAt = $createdAt;
        $this->alias = $alias;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCard(): Card
    {
        return $this->card;
    }

    public function getAddedAt(): \DateTimeImmutable
    {
        return $this->addedAt;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): UserCard
    {
        $this->alias = $alias;
        return $this;
    }
}
