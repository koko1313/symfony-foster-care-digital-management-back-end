<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public const ROLE_ADMIN_REFERENCE = 'role-admin';

    public function load(ObjectManager $manager)
    {
        $roleAdmin = new Role();
        $roleAdmin->setName("ROLE_ADMIN");
        $manager->persist($roleAdmin);

//        $role = new Role();
//        $role->setName("ROLE_USER");
//        $manager->persist($role);

        $manager->flush();

        // other fixtures can get this object using the RoleFixtures::ROLE_ADMIN_REFERENCE constant
        $this->addReference(self::ROLE_ADMIN_REFERENCE, $roleAdmin);
    }
}