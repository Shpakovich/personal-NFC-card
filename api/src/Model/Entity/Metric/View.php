<?php

declare(strict_types=1);

namespace App\Model\Entity\Metric;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Profile\Profile;
use App\Model\Entity\User\UserCard;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="metrics_views")
 */
class View
{
    /**
     * @ORM\Id
     * @ORM\Column(type="entity_id")
     */
    private Id $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\User\UserCard")
     * @ORM\JoinColumn(name="user_card_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private UserCard $card;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\Profile\Profile")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private Profile $profile;

    public function __construct(
        Id $id,
        \DateTimeImmutable $createdAt,
        UserCard $card,
        Profile $profile
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->card = $card;
        $this->profile = $profile;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCard(): UserCard
    {
        return $this->card;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }
}
