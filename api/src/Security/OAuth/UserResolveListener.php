<?php

declare(strict_types=1);

namespace App\Security\OAuth;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\UserResolveEvent;

class UserResolveListener
{
    private UserProviderInterface $userProvider;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserProviderInterface $userProvider, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userProvider = $userProvider;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function onUserResolve(UserResolveEvent $event): void
    {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->userProvider->loadUserByIdentifier($event->getUsername());
        if (null === $user) {
            return;
        }

        if (!$this->userPasswordHasher->isPasswordValid($user, $event->getPassword())) {
            return;
        }

        $event->setUser($user);
    }
}
