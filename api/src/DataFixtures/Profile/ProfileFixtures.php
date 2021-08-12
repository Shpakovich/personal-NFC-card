<?php

namespace App\DataFixtures\Profile;

use App\DataFixtures\Field\FieldFixtures;
use App\DataFixtures\User\CardFixtures;
use App\DataFixtures\User\UserFixtures;
use App\Model\Entity\Common\Id;
use App\Model\Entity\Profile\Field;
use App\Model\Entity\Profile\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProfileFixtures extends Fixture implements DependentFixtureInterface
{
    public const PUBLISHED_REF = 'profile_published';

    public function load(ObjectManager $manager): void
    {
        /** @var \App\Model\Entity\User\User $userOne */
        $userOne = $this->getReference(UserFixtures::ACTIVE_1_REF);

        /** @var \App\Model\Entity\User\User $userTwo */
        $userTwo = $this->getReference(UserFixtures::ACTIVE_2_REF);

        /** @var \App\Model\Entity\User\UserCard $cardOne */
        $cardOne = $this->getReference(CardFixtures::CARD_USER_1_REF);

        /** @var \App\Model\Entity\User\UserCard $cardTwo */
        $cardTwo = $this->getReference(CardFixtures::CARD_USER_2_REF);

        /** @var \App\Model\Entity\Field\Field $workPhoneField */
        $workPhoneField = $this->getReference(FieldFixtures::WORK_PHONE_REF);

        /** @var \App\Model\Entity\Field\Field $emailField */
        $emailField = $this->getReference(FieldFixtures::EMAIL_REF);

        $publishedOne = new Profile(
            Id::next(),
            $userOne,
            'Director profile',
            'Patrick',
            Profile::DEFAULT_NAME,
            new \DateTimeImmutable()
        );

        $publishedOne
            ->setCard($cardOne)
            ->setPost('CEO')
            ->setDescription('Unpleasant nor diminution excellence apartments imprudence the met new. Draw part them'
                . 'he an to he roof only. Music leave say doors him. Tore bred form if sigh case as do. Staying he no'
                . 'looking if do opinion. Sentiments way understood end partiality and his.')
            ->publish();

        $publishedOne
            ->addField(new Field(Id::next(), $publishedOne, $workPhoneField, '+79997776644', 10))
            ->addField(new Field(Id::next(), $publishedOne, $workPhoneField, '+79991112233', 20))
            ->addField(new Field(Id::next(), $publishedOne, $emailField, 'work@email.ru', 10));

        $hidden = new Profile(
            Id::next(),
            $userOne,
            'Hidden profile',
            'Hidden',
            Profile::DEFAULT_NICKNAME,
            new \DateTimeImmutable()
        );

        $publishedTwo = new Profile(
            Id::next(),
            $userTwo,
            'Hidden profile',
            'Hidden',
            Profile::DEFAULT_NICKNAME,
            new \DateTimeImmutable()
        );

        $publishedTwo
            ->setCard($cardTwo)
            ->setPost('CEO')
            ->setDescription('Unpleasant nor diminution excellence apartments imprudence the met new. Draw part them'
                . 'he an to he roof only. Music leave say doors him. Tore bred form if sigh case as do. Staying he no'
                . 'looking if do opinion. Sentiments way understood end partiality and his.')
            ->publish();

        $manager->persist($publishedOne);
        $manager->persist($hidden);
        $manager->persist($publishedTwo);
        $manager->flush();

        $this->addReference(self::PUBLISHED_REF, $publishedOne);
    }

    public function getDependencies(): array
    {
        return [
            \App\DataFixtures\CardFixtures::class,
            FieldFixtures::class,
        ];
    }
}
