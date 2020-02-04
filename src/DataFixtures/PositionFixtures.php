<?php

namespace App\DataFixtures;

use App\Entity\Position;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PositionFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
        $position = new Position();
        $position->setName("ОЕПГ");
        $position->setRole($this->getReference(RoleFixtures::ROLE_OEPG_REFERENCE));

        $manager->persist($position);
        $manager->flush();
    }

    public function getDependencies() {
        return array(
            RoleFixtures::class,
        );
    }
}