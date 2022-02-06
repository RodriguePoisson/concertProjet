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

        $band3 = new ConcertBand();
        $band3 ->setPicture("acdc.jpg")
        ->setDescription("Plus grand groupe de rock")
        ->setName("ACDC")
        ->addArtist($this->getReference("5"))
        ->addArtist($this->getReference("6"))
        ->addArtist($this->getReference("7"));

        $manager->persist($band3);
        $manager->flush();

        $band4 = new ConcertBand();
        $band4 ->setPicture("slashGun.jpg")
        ->setDescription("le seul important de gun n roses")
        ->setName("Le plus grand")
        ->addArtist($this->getReference("9"));
    

        $manager->persist($band4);
        $manager->flush();

        $band5 = new ConcertBand();
        $band5 ->setPicture("jenesaispas.jpg")
        ->setDescription("C'est quand même long de faire des fixtures pour montrer que la pagination marche")
        ->setName("La pagination")
        ->addArtist($this->getReference("2"));


        $manager->persist($band5);
        $manager->flush();

        $band6 = new ConcertBand();
        $band6 ->setPicture("que2.jpg")
        ->setDescription("Plus que 2 !!!")
        ->setName("plusquedeux")
        ->addArtist($this->getReference("6"));


        $manager->persist($band6);
        $manager->flush();

        $band7 = new ConcertBand();
        $band7 ->setPicture("perrineRodrigue.jpg")
        ->setDescription("Le karaoké du dimanche catastrophique")
        ->setName("Karaoké du dimanche")
        ->addArtist($this->getReference("10"))
        ->addArtist($this->getReference("11"));


        $this->addReference("a",$band3);
        $this->addReference("b",$band4);
        $this->addReference("c",$band1);
        $this->addReference("d",$band2);
        $this->addReference("e",$band5);
        $this->addReference("f",$band6);
        $this->addReference("g",$band7);

        $manager->persist($band7);
        $manager->flush();

    }

    public function getDependencies()
    {
        return[
            MemberFixture::class,
        ];
    }
}
