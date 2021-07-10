<?php

declare(strict_types=1);

namespace App\Security;

use App\Model\Entity\User\Email;
use App\Model\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;


class UserProvider implements UserProviderInterface
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->users->findByEmail(new Email($identifier));
        if ($user === null) {
            throw new UserNotFoundException();
        }

        return new UserIdentity($user->getEmail()->getValue(), $user->getPasswordHash());
    }

    public function refreshUser(UserInterface $user)
    {
    }

    public function supportsClass(string $class): bool
    {
        return $class === UserIdentity::class;
    }

    /**
     * @deprecated
     */
    public function loadUserByUsername(string $username)
    {
    }
}
