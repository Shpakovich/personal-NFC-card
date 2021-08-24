<?php

declare(strict_types=1);

namespace App\Model\Entity\User;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Profile\Profile;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="favorites", uniqueConstraints={
 *          @ORM\UniqueConstraint(name="favorites_user_id_profile_id_uidx", columns={"user_id", "profile_id"}),
 *     })
 */
class Favorite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="entity_id")
     */
    private Id $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\User\User", inversedBy="favorite")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="RESTRICT", nullable=false)
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\Profile\Profile")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="RESTRICT", nullable=false)
     */
    private Profile $profile;

    public function __construct(Id $id, User $user, Profile $profile)
    {
        $this->id = $id;
        $this->user = $user;
        $this->profile = $profile;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }
}
