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

        $angusYoung = new ConcertArtist();
        $angusYoung ->setName("Angus")
                    ->setLastName("Young")
                    ->setPseudo("Angus Young")
                    ->setPicture("angus.jpg");
        $this->addReference("5",$angusYoung);

        $BrianJohnson = new ConcertArtist();
        $BrianJohnson ->setName("Brian")
                    ->setLastName("Johnson")
                    ->setPseudo("Brian Johnson")
                    ->setPicture("brian.jpg");
        $this->addReference("6",$BrianJohnson);

        $stevieYoung = new ConcertArtist();
        $stevieYoung ->setName("Stevie")
                    ->setLastName("Young")
                    ->setPseudo("Stevie Young")
                    ->setPicture("stevieyoung.jpg");
        $this->addReference("7",$stevieYoung);


        $axl = new ConcertArtist();
        $axl ->setName("Axl")
                    ->setLastName("Rose")
                    ->setPseudo("Axl Rose")
                    ->setPicture("axl.jpg");
        $this->addReference("8",$axl);
        $slash = new ConcertArtist();
        $slash  ->setPseudo("Slash")
                ->setPicture("slash.jpg");
        $this->addReference("9",$slash);

        $perrine = new ConcertArtist();
        $perrine ->setName("Perrine")
                    ->setLastName("Youinou")
                    ->setPseudo("Perrine")
                    ->setPicture("perrine.jpg");
        $this->addReference("10",$perrine);
        $rodrigue = new ConcertArtist();
        $rodrigue  ->setPseudo("Rodrigue")
                ->setPicture("rodrigue.jpg");
        $this->addReference("11",$rodrigue);




        // $product = new Product();
        // $manager->persist($product);
        $manager->persist($ratm1);
        $manager->persist($ratm2);
        $manager->persist($sabaton1);
        $manager->persist($sabaton2);
        $manager->persist($angusYoung);
        $manager->persist($BrianJohnson);
        $manager->persist($stevieYoung);
        $manager->persist($slash);
        $manager->persist($axl);
        $manager->persist($perrine);
        $manager->persist($rodrigue);
        $manager->flush();
    }
}
