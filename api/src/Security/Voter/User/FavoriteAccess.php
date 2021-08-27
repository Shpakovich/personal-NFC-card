<?php

declare(strict_types=1);

namespace App\Security\Voter\User;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\Favorite;
use App\Model\Entity\User\Role;
use App\Model\Entity\User\UserCard;
use App\Security\UserIdentity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class FavoriteAccess extends Voter
{
    public const EDIT = 'edit';

    protected function supports(string $attribute, $subject): bool
    {
        return $subject instanceof Favorite && $attribute === self::EDIT;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserIdentity) {
            return false;
        }

        if (!$subject instanceof Favorite) {
            return false;
        }

        return match ($attribute) {
            self::EDIT => $this->canEdit($subject, $user),
            default => false,
        };
    }

    private function canEdit(Favorite $favorite, UserIdentity $user): bool
    {
        return $favorite->getUser()->getId()->isEqual(new Id($user->getId()));
    }
}
