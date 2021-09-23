<?php

declare(strict_types=1);

namespace App\Security\Voter\Field;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\CustomField;
use App\Model\Entity\User\Role;
use App\Security\UserIdentity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CustomFieldAccess extends Voter
{
    public const VIEW = 'view';
    public const EDIT = 'edit';

    private AuthorizationCheckerInterface $security;

    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return $subject instanceof CustomField && in_array($attribute, [self::VIEW, self::EDIT]);
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

        if (!$subject instanceof CustomField) {
            return false;
        }

        return match ($attribute) {
            self::VIEW => $this->canView($subject, $user),
            self::EDIT => $this->canEdit($subject, $user),
            default => false,
        };
    }

    private function canView(CustomField $profile, UserIdentity $user): bool
    {
        return $this->security->isGranted(Role::ADMIN)
            || $profile->getUser()->getId()->isEqual(new Id($user->getId()));
    }

    private function canEdit(CustomField $profile, UserIdentity $user): bool
    {
        return $this->security->isGranted(Role::ADMIN)
            || $profile->getUser()->getId()->isEqual(new Id($user->getId()));
    }
}
