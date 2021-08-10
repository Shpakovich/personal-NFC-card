<?php

declare(strict_types=1);

namespace App\Security\Voter\Profile;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Profile\Profile;
use App\Model\Entity\User\Role;
use App\Security\UserIdentity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProfileAccess extends Voter
{
    public const VIEW = 'view';

    private AuthorizationCheckerInterface $security;

    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return $subject instanceof Profile && in_array($attribute, [self::VIEW]);
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

        if (!$subject instanceof Profile) {
            return false;
        }

        return $this->security->isGranted(Role::ADMIN)
            || $subject->getUser()->getId()->isEqual(new Id($user->getId()));
    }
}
