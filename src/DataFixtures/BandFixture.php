<?php

namespace App\DataFixtures;

use App\Entity\ConcertArtist;
use App\Entity\ConcertBand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BandFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {

        $band1 = new ConcertBand();

        $band1  ->setPicture("sabaton.jpg")
                ->setDescription("Tres bon groupe de metal")
                ->setName("Sabaton")
                ->addArtist($this->getReference(MemberFixture::MEMBER_REFERENCE))
                ->addArtist($this->getReference("2"));

        $manager->persist($band1);
        $manager->flush();

        $band2 = new ConcertBand();

        $band2 ->setPicture("ratm.jpg")
                ->setDescription("Tres bon groupe")
                ->setName("Rage Against The Machine")
                ->addArtist($this->getReference("3"))
                ->addArtist($this->getReference("4"));

        $manager->persist($band2);
        $manager->flush();

    }

    public function getDependencies()
    {
        return[
            MemberFixture::class,
        ];
    }
}
