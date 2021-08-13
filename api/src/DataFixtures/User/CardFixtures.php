<?php

namespace App\DataFixtures\User;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\UserCard;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CardFixtures extends Fixture implements DependentFixtureInterface
{
    public const CARD_USER_1_REF = 'user_card_user_1';
    public const CARD_USER_2_REF = 'user_card_user_2';

    public function load(ObjectManager $manager): void
    {
        /** @var \App\Model\Entity\User\User $userOne */
        $userOne = $this->getReference(UserFixtures::ACTIVE_1_REF);

        /** @var \App\Model\Entity\User\User $userTwo */
        $userTwo = $this->getReference(UserFixtures::ACTIVE_2_REF);

        /** @var \App\Model\Entity\Card\Card $cardOne */
        $cardOne = $this->getReference(\App\DataFixtures\CardFixtures::CARD_1_REF);

        /** @var \App\Model\Entity\Card\Card $cardTwo */
        $cardTwo = $this->getReference(\App\DataFixtures\CardFixtures::CARD_2_REF);

        $userCardOne = new UserCard(Id::next(), $userOne, $cardOne, new \DateTimeImmutable(), 'card');
        $userCardTwo = new UserCard(Id::next(), $userTwo, $cardTwo, new \DateTimeImmutable());

        $manager->persist($userCardOne);
        $manager->persist($userCardTwo);
        $manager->flush();

        $this->addReference(self::CARD_USER_1_REF, $userCardOne);
        $this->addReference(self::CARD_USER_2_REF, $userCardTwo);
    }

    public function getDependencies(): array
    {
        return [
            \App\DataFixtures\CardFixtures::class,
        ];
    }
}
