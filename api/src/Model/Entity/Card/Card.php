<?php

declare(strict_types=1);

namespace App\Model\Entity\Card;

use App\Model\Entity\User\User;
use App\Model\Entity\UserCard\UserCard;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cards")
 */
class Card
{
    /**
     * @ORM\Id
     * @ORM\Column(type="card_id")
     */
    private Id $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\User\User", cascade={"persist"})
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", onDelete="RESTRICT", nullable=false)
     */
    private User $creator;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Model\Entity\UserCard\UserCard", mappedBy="card")
     */
    private ?UserCard $owner = null;

    public function __construct(Id $id, User $creator, \DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->creator = $creator;
        $this->createdAt = $createdAt;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getCreator(): User
    {
        return $this->creator;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getOwner(): UserCard
    {
        return $this->owner;
    }
}
