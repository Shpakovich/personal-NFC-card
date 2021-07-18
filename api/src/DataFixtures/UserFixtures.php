<?php

namespace App\DataFixtures;

use App\Model\Entity\User\Email;
use App\Model\Entity\User\Id;
use App\Model\Entity\User\Token;
use App\Model\Entity\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class UserFixtures extends Fixture
{
    private PasswordHasherInterface $hasher;

    public function __construct(PasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User(
            Id::next(),
            new Email('aaa@ccc.ru'),
            $this->hasher->hash('11111'),
            new Token('2ba243bc-af86-4c23-8410-fd4c0436ae31', new \DateTimeImmutable()),
            (new \DateTimeImmutable())->modify('-5 days')
        );
        $user->confirm(new \DateTimeImmutable());

        $manager->persist($user);
        $manager->flush();
    }
}
