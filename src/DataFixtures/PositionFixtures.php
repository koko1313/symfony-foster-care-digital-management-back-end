<?php

namespace App\DataFixtures;

use App\Constants\Positions;
use App\Constants\Roles;
use App\Entity\Position;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PositionFixtures extends Fixture implements DependentFixtureInterface {

    public function load(ObjectManager $manager) {
        $position = new Position();
        $position->setName(Positions::POSITION_OEPG);

        $roleOEPG = $manager->getRepository(Role::class)->findOneBy(["name" => Roles::ROLE_OEPG]);
        $position->setRole($roleOEPG);

        $manager->persist($position);
        $manager->flush();
    }

    public function getDependencies() {
        return array(
            RoleFixtures::class,
        );
    }
}