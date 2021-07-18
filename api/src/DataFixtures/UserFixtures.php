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
        $active = new User(
            Id::next(),
            new Email('aaa@aaa.ru'),
            $this->hasher->hash('11111'),
            new Token(Id::next(), new \DateTimeImmutable()),
            (new \DateTimeImmutable())->modify('-5 days')
        );
        $active->confirm((new \DateTimeImmutable())->modify('-5 hours'));

        $wait = new User(
            Id::next(),
            new Email('aaa@bbb.ru'),
            $this->hasher->hash('11111'),
            new Token(Id::next(), new \DateTimeImmutable()),
            (new \DateTimeImmutable())->modify('-3 days')
        );

        $block = new User(
            Id::next(),
            new Email('aaa@ccc.ru'),
            $this->hasher->hash('11111'),
            new Token(Id::next(), new \DateTimeImmutable()),
            (new \DateTimeImmutable())->modify('-10 days')
        );
        $block->block((new \DateTimeImmutable())->modify('-1 days'));

        $manager->persist($active);
        $manager->persist($wait);
        $manager->persist($block);

        $manager->flush();
    }
}
