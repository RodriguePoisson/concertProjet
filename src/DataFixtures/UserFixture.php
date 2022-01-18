<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @param ObjectManager $manager
 */

class UserFixture extends Fixture
{
    private $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $super_admin = new User();

        $super_admin->setEmail("laurechristol@symfonyboss.com")
                    ->setName("Laure")
                    ->setLastName("Christol")
                    ->setPassword($this->hasher->hashPassword($super_admin,"azeaze"))
                    ->setRoles([User::ROLE_ADMIN]);
        $manager->persist($super_admin);
        $manager->flush();
    }
}
