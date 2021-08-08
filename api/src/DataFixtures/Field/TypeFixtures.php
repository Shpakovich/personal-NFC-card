<?php

namespace App\DataFixtures\Field;

use App\DataFixtures\User\UserFixtures;
use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture implements DependentFixtureInterface
{
    public const PHONE_REF = 'type_phone';
    public const NETWORK_REF = 'type_network';
    public const EMAIL_REF = 'type_email';

    public function load(ObjectManager $manager): void
    {
        /** @var \App\Model\Entity\User\User $admin */
        $admin = $this->getReference(UserFixtures::ADMIN_REF);

        $phone = new Type(
            Id::next(),
            'Телефон',
            10,
            $admin,
            (new \DateTimeImmutable())->modify('-2 days')
        );

        $network = new Type(
            Id::next(),
            'Социальная сеть',
            20,
            $admin,
            (new \DateTimeImmutable())->modify('-6 hours')
        );

        $email = new Type(
            Id::next(),
            'Email',
            30,
            $admin,
            (new \DateTimeImmutable())->modify('-7 hours')
        );

        $this->addReference(self::PHONE_REF, $phone);
        $this->addReference(self::NETWORK_REF, $network);
        $this->addReference(self::EMAIL_REF, $email);

        $manager->persist($phone);
        $manager->persist($network);
        $manager->persist($email);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
