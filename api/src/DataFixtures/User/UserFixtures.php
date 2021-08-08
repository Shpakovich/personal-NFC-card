<?php

namespace App\DataFixtures\User;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\Email;
use App\Model\Entity\User\Token;
use App\Model\Entity\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const ADMIN_REF = 'user_admin';
    public const ACTIVE_REF = 'user_active';

    private PasswordHasherInterface $hasher;

    public function __construct(PasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User(
            Id::next(),
            new Email('aaa@aaa.ru'),
            $this->hasher->hash('11111'),
            new Token(Id::next()->getValue(), new \DateTimeImmutable()),
            (new \DateTimeImmutable())->modify('-5 days')
        );
        $admin->confirm((new \DateTimeImmutable())->modify('-5 hours'));

        $wait = new User(
            Id::next(),
            new Email('aaa@bbb.ru'),
            $this->hasher->hash('11111'),
            new Token(Id::next()->getValue(), new \DateTimeImmutable()),
            (new \DateTimeImmutable())->modify('-3 days')
        );

        $block = new User(
            Id::next(),
            new Email('aaa@ccc.ru'),
            $this->hasher->hash('11111'),
            new Token(Id::next()->getValue(), new \DateTimeImmutable()),
            (new \DateTimeImmutable())->modify('-10 days')
        );
        $block->block((new \DateTimeImmutable())->modify('-1 days'));

        $active = new User(
            Id::next(),
            new Email('aaa@ddd.ru'),
            $this->hasher->hash('11111'),
            new Token(Id::next()->getValue(), new \DateTimeImmutable()),
            (new \DateTimeImmutable())->modify('-3 days')
        );
        $active->confirm((new \DateTimeImmutable())->modify('-9 hours'));

        $manager->persist($admin);
        $manager->persist($wait);
        $manager->persist($block);
        $manager->persist($active);

        $manager->flush();

        $this->addReference(self::ADMIN_REF, $admin);
        $this->addReference(self::ACTIVE_REF, $active);
    }
}
