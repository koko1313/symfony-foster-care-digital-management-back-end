<?php

namespace App\DataFixtures;

use App\Constants\Roles;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roleAdmin = new Role();
        $roleAdmin->setName(Roles::ROLE_ADMIN);
        $manager->persist($roleAdmin);

        $roleOepg = new Role();
        $roleOepg->setName(Roles::ROLE_OEPG);
        $manager->persist($roleOepg);

        $manager->flush();
    }
}