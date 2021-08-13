<?php

namespace App\DataFixtures\User;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\Email;
use App\Model\Entity\User\Role;
use App\Model\Entity\User\Token;
use App\Model\Entity\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const ADMIN_REF = 'user_admin';
    public const ACTIVE_1_REF = 'user_active_1';
    public const ACTIVE_2_REF = 'user_active_2';

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
            Role::admin(),
            (new \DateTimeImmutable())->modify('-5 days')
        );
        $admin->confirm((new \DateTimeImmutable())->modify('-5 hours'));

        $wait = new User(
            Id::next(),
            new Email('aaa@bbb.ru'),
            $this->hasher->hash('11111'),
            new Token(Id::next()->getValue(), new \DateTimeImmutable()),
            Role::user(),
            (new \DateTimeImmutable())->modify('-3 days')
        );

        $block = new User(
            Id::next(),
            new Email('aaa@ccc.ru'),
            $this->hasher->hash('11111'),
            new Token(Id::next()->getValue(), new \DateTimeImmutable()),
            Role::user(),
            (new \DateTimeImmutable())->modify('-10 days')
        );
        $block->block((new \DateTimeImmutable())->modify('-1 days'));

        $activeOne = new User(
            Id::next(),
            new Email('aaa@ddd.ru'),
            $this->hasher->hash('11111'),
            new Token(Id::next()->getValue(), new \DateTimeImmutable()),
            Role::user(),
            (new \DateTimeImmutable())->modify('-3 days')
        );
        $activeOne->confirm((new \DateTimeImmutable())->modify('-9 hours'));

        $activeTwo = new User(
            Id::next(),
            new Email('aaa@eee.ru'),
            $this->hasher->hash('11111'),
            new Token(Id::next()->getValue(), new \DateTimeImmutable()),
            Role::user(),
            (new \DateTimeImmutable())->modify('-3 days')
        );
        $activeTwo->confirm((new \DateTimeImmutable())->modify('-9 hours'));

        $manager->persist($admin);
        $manager->persist($wait);
        $manager->persist($block);
        $manager->persist($activeOne);
        $manager->persist($activeTwo);

        $manager->flush();

        $this->addReference(self::ADMIN_REF, $admin);
        $this->addReference(self::ACTIVE_1_REF, $activeOne);
        $this->addReference(self::ACTIVE_2_REF, $activeTwo);
    }
}
