<?php

declare(strict_types=1);

namespace App\Security\OAuth;

use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\UserResolveEvent;

class UserResolveListener
{
    private UserProviderInterface $userProvider;
    private PasswordHasherInterface $passwordHasher;

    public function __construct(UserProviderInterface $userProvider, PasswordHasherInterface $passwordHasher)
    {
        $this->userProvider = $userProvider;
        $this->passwordHasher = $passwordHasher;
    }

    public function onUserResolve(UserResolveEvent $event): void
    {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->userProvider->loadUserByIdentifier($event->getUsername());
        if (null === $user) {
            return;
        }

        if (!$this->passwordHasher->verify($user->getPassword(), $event->getPassword())) {
            return;
        }

        $event->setUser($user);
    }
}
