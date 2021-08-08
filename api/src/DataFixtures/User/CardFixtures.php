<?php

namespace App\DataFixtures\User;

use App\Model\Entity\Common\Id;
use App\Model\Entity\User\UserCard;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CardFixtures extends Fixture implements DependentFixtureInterface
{
    public const CARD_USER_REF = 'user_card_user';

    public function load(ObjectManager $manager): void
    {
        /** @var \App\Model\Entity\User\User $user */
        $user = $this->getReference(UserFixtures::ACTIVE_REF);

        /** @var \App\Model\Entity\Card\Card $card */
        $card = $this->getReference(\App\DataFixtures\CardFixtures::CARD_REF);

        $userCard = new UserCard(Id::next(), $user, $card, new \DateTimeImmutable(), 'card');

        $manager->persist($userCard);
        $manager->flush();

        $this->addReference(self::CARD_USER_REF, $userCard);
    }

    public function getDependencies(): array
    {
        return [
            \App\DataFixtures\CardFixtures::class,
        ];
    }
}
