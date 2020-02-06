<?php

namespace App\DataFixtures;

use App\Constants\Roles;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public const ROLE_ADMIN_REFERENCE = 'role-admin';
    public const ROLE_OEPG_REFERENCE = 'role-oepg';

    public function load(ObjectManager $manager)
    {
        $roleAdmin = new Role();
        $roleAdmin->setName(Roles::ROLE_ADMIN);
        $manager->persist($roleAdmin);

        $roleOepg = new Role();
        $roleOepg->setName(Roles::ROLE_OEPG);
        $manager->persist($roleOepg);

        $manager->flush();

        // other fixtures can get this object using the RoleFixtures::ROLE_OEPG_REFERENCE constant
        $this->addReference(self::ROLE_OEPG_REFERENCE, $roleOepg);
        $this->addReference(self::ROLE_ADMIN_REFERENCE, $roleAdmin);
    }
}