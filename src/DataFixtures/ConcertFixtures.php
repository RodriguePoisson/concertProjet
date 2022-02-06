<?php

namespace App\DataFixtures;

use App\Entity\ConcertConcert;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class ConcertFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $concert2018 = new ConcertConcert();

        $concert2018->setDate(new DateTime("01/01/2018"))
                    ->setDuration(180)
                    ->setPicture("2018.jpg")
                    ->setDescription("Le concert d'acdc avec axl rose en invité")
                    ->addBandIn($this->getReference("a"))
                    ->addArtistInvited($this->getReference("8"));

        $prochainConcert1 = new ConcertConcert();

        $prochainConcert1->setDate(new DateTime("01/01/2022"))
                    ->setDuration(100)
                    ->setPicture("c1.jpg")
                    ->setDescription("Magnifique concert")
                    ->addBandIn($this->getReference("e"))
                    ->addBandIn($this->getReference("f"));


        $prochainConcert2 = new ConcertConcert();

        $prochainConcert2->setDate(new DateTime("05/01/2022"))
                    ->setDuration(100)
                    ->setPicture("c2.jpg")
                    ->setDescription("Je ne sais plus qui joue dedans")
                    ->addBandIn($this->getReference("c"));

        $prochainConcert3 = new ConcertConcert();

        $prochainConcert3->setDate(new DateTime("06/01/2022"))
                ->setDuration(300)
                ->setPicture("c3.jpg")
                ->setDescription("Un tres beau concert")
                ->addBandIn($this->getReference("a"));

                $prochainConcert4 = new ConcertConcert();
                $prochainConcert4->setDate(new DateTime("07/08/2021"))
                ->setDuration(300)
                ->setPicture("c4.jpg")
                ->setDescription("Les meilleurs")
                ->addBandIn($this->getReference("g"));


                $prochainConcert5 = new ConcertConcert();
                $prochainConcert5->setDate(new DateTime("08/01/2022"))
                ->setDuration(300)
                ->setPicture("c5.jpg")
                ->setDescription("Les meilleurs")
                ->addBandIn($this->getReference("f"));

                $prochainConcert6 = new ConcertConcert();
                $prochainConcert6->setDate(new DateTime("09/01/2022"))
                ->setDuration(300)
                ->setPicture("c6.jpg")
                ->setDescription("Les meilleurs")
                ->addBandIn($this->getReference("f"))
                ->addBandIn($this->getReference("g"));

                $prochainConcert7 = new ConcertConcert();

        $prochainConcert7->setDate(new DateTime("01/01/2018"))
                    ->setDuration(180)
                    ->setPicture("c7.jpg")
                    ->setDescription("Le concert d'acdc avec axl rose en invité LE RETOUR")
                    ->addBandIn($this->getReference("a"))
                    ->addArtistInvited($this->getReference("8"));


        $manager->persist($concert2018);
        $manager->persist($prochainConcert1);
        $manager->persist($prochainConcert2);
        $manager->persist($prochainConcert3);
        $manager->persist($prochainConcert4);
        $manager->persist($prochainConcert5);
        $manager->persist($prochainConcert6);
        $manager->persist($prochainConcert7);
        $manager->flush();
    }
    public function getDependencies()
    {
        return[
            BandFixture::class,
            MemberFixture::class,
            
        ];
    }
}
