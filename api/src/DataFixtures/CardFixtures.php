<?php

namespace App\DataFixtures;

use App\DataFixtures\User\UserFixtures;
use App\Model\Entity\Card\Card;
use App\Model\Entity\Common\Id;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CardFixtures extends Fixture implements DependentFixtureInterface
{
    public const CARD_1_REF = 'card_1';
    public const CARD_2_REF = 'card_2';

    public function load(ObjectManager $manager): void
    {
        /** @var \App\Model\Entity\User\User $admin */
        $admin = $this->getReference(UserFixtures::ADMIN_REF);

        $cardOne = new Card(
            Id::next(),
            $admin,
            (new \DateTimeImmutable())->modify(sprintf('-%d hours', random_int(1, 40)))
        );

        $manager->persist($cardOne);

        $cardTwo = new Card(
            Id::next(),
            $admin,
            (new \DateTimeImmutable())->modify(sprintf('-%d hours', random_int(1, 40)))
        );
        $manager->persist($cardTwo);

        for ($i = 0; $i < 100; ++$i) {
            $card = new Card(
                Id::next(),
                $admin,
                (new \DateTimeImmutable())->modify(sprintf('-%d hours', random_int(1, 40)))
            );
            $manager->persist($card);
        }

        $this->addReference(self::CARD_1_REF, $cardOne);
        $this->addReference(self::CARD_2_REF, $cardTwo);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
