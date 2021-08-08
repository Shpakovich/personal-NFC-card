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
        /** @var \App\Model\Entity\User\User $user */
        $user = $this->getReference(UserFixtures::ACTIVE_REF);

        /** @var \App\Model\Entity\User\UserCard $card */
        $card = $this->getReference(CardFixtures::CARD_USER_REF);

        /** @var \App\Model\Entity\Field\Field $workPhoneField */
        $workPhoneField = $this->getReference(FieldFixtures::WORK_PHONE_REF);

        /** @var \App\Model\Entity\Field\Field $emailField */
        $emailField = $this->getReference(FieldFixtures::EMAIL_REF);

        $published = new \App\Model\Entity\Profile\Profile(
            Id::next(),
            $user,
            'Director profile',
            'Patrick',
            Profile::DEFAULT_NAME,
            new \DateTimeImmutable()
        );

        $published
            ->setCard($card)
            ->setPost('CEO')
            ->setDescription('Unpleasant nor diminution excellence apartments imprudence the met new. Draw part them'
                . 'he an to he roof only. Music leave say doors him. Tore bred form if sigh case as do. Staying he no'
                . 'looking if do opinion. Sentiments way understood end partiality and his.')
            ->setIsPublished(true);

        $published
            ->addField(new Field(Id::next(), $published, $workPhoneField, '+79997776644', 10))
            ->addField(new Field(Id::next(), $published, $workPhoneField, '+79991112233', 20))
            ->addField(new Field(Id::next(), $published, $emailField, 'work@email.ru', 10));

        $manager->persist($published);
        $manager->flush();

        $this->addReference(self::PUBLISHED_REF, $published);
    }

    public function getDependencies(): array
    {
        return [
            \App\DataFixtures\CardFixtures::class,
            FieldFixtures::class,
        ];
    }
}
