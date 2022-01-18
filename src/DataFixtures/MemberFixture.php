<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ConcertArtist;

class MemberFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     */

    public const MEMBER_REFERENCE = 'member';


    public function load(ObjectManager $manager): void
    {


        $sabaton1 = new ConcertArtist();
        $sabaton1   ->setName("Joakim")
                    ->setLastName("Brodén")
                    ->setPseudo("Joakim Brodén")
                    ->setPicture("joakimBrodén.jpg");
        $this->addReference(self::MEMBER_REFERENCE,$sabaton1);
        $sabaton2 = new ConcertArtist();
        $sabaton2  ->setName("Pär")
            ->setLastName("Sundström")
            ->setPseudo("Pär Sundström")
            ->setPicture("PärSundström.jpg");
        $this->addReference("2",$sabaton2);

        $ratm1 = new ConcertArtist();
        $ratm1
            ->setPseudo("Zack de la Rocha")
            ->setPicture("ZackdelaRocha.jpg");
        $this->addReference("3",$ratm1);
        $ratm2 = new ConcertArtist();
        $ratm2
            ->setPseudo("Tom Morello")
            ->setPicture("TomMorello.jpg");
        $this->addReference("4",$ratm2);




        // $product = new Product();
        // $manager->persist($product);
        $manager->persist($ratm1);
        $manager->persist($ratm2);
        $manager->persist($sabaton1);
        $manager->persist($sabaton2);
        $manager->flush();
    }
}
