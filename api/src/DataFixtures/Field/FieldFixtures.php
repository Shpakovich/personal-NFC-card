<?php

namespace App\DataFixtures\Field;

use App\DataFixtures\User\UserFixtures;
use App\Model\Entity\Common\Id;
use App\Model\Entity\Field\Color;
use App\Model\Entity\Field\Field;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FieldFixtures extends Fixture implements DependentFixtureInterface
{
    public const HOME_PHONE_REF = 'field_home';
    public const WORK_PHONE_REF = 'field_work';
    public const NETWORK_FACEBOOK_REF = 'field_facebook';
    public const EMAIL_REF = 'field_email';

    public function load(ObjectManager $manager): void
    {
        /** @var \App\Model\Entity\User\User $admin */
        $admin = $this->getReference(UserFixtures::ADMIN_REF);

        /** @var \App\Model\Entity\Field\Type $phoneType */
        $phoneType = $this->getReference(TypeFixtures::PHONE_REF);

        /** @var \App\Model\Entity\Field\Type $networkType */
        $networkType = $this->getReference(TypeFixtures::NETWORK_REF);

        /** @var \App\Model\Entity\Field\Type $emailType */
        $emailType = $this->getReference(TypeFixtures::EMAIL_REF);

        $homePhone = new Field(
            Id::next(),
            'Домашний телефон',
            $phoneType,
            new Color('#fff'),
            new Color('#000'),
            $admin,
            (new \DateTimeImmutable())->modify('-2 days')
        );

        $workPhone = new Field(
            Id::next(),
            'Рабочий телефон',
            $phoneType,
            new Color('#fff'),
            new Color('#000'),
            $admin,
            (new \DateTimeImmutable())->modify('-2 days')
        );

        $facebookNetwork = new Field(
            Id::next(),
            'Facebook',
            $networkType,
            new Color('#fff'),
            new Color('#000'),
            $admin,
            (new \DateTimeImmutable())->modify('-2 days')
        );

        $email = new Field(
            Id::next(),
            'Email',
            $emailType,
            new Color('#fff'),
            new Color('#000'),
            $admin,
            (new \DateTimeImmutable())->modify('-2 days')
        );

        $manager->persist($homePhone);
        $manager->persist($workPhone);
        $manager->persist($facebookNetwork);
        $manager->persist($email);
        $manager->flush();

        $this->addReference(self::HOME_PHONE_REF, $homePhone);
        $this->addReference(self::WORK_PHONE_REF, $workPhone);
        $this->addReference(self::NETWORK_FACEBOOK_REF, $facebookNetwork);
        $this->addReference(self::EMAIL_REF, $email);
    }

    public function getDependencies(): array
    {
        return [
            TypeFixtures::class,
        ];
    }
}
