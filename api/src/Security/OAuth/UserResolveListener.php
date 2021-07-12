<?php

declare(strict_types=1);

namespace App\Security\OAuth;

use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\UserResolveEvent;

class UserResolveListener
{
    private UserProviderInterface $userProvider;
    private PasswordHasherInterface $passwordHasher;
    private UserCheckerInterface $userChecker;

    public function __construct(
        UserProviderInterface $userProvider,
        PasswordHasherInterface $passwordHasher,
        UserCheckerInterface $userChecker
    ) {
        $this->userProvider = $userProvider;
        $this->passwordHasher = $passwordHasher;
        $this->userChecker = $userChecker;
    }

    public function onUserResolve(UserResolveEvent $event): void
    {
        /** @var null|\App\Security\UserIdentity $user */
        $user = $this->userProvider->loadUserByIdentifier($event->getUsername());
        if (null === $user) {
            return;
        }

        try {
            $this->userChecker->checkPreAuth($user);
        } catch (AccountStatusException) {
            return;
        }

        if (!$this->passwordHasher->verify((string)$user->getPassword(), $event->getPassword())) {
            return;
        }

        $event->setUser($user);
    }
}
