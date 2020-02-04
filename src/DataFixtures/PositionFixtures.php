<?php

namespace App\DataFixtures;

use App\Entity\Position;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PositionFixtures extends Fixture {
    public function load(ObjectManager $manager) {
        $position = new Position();
        $position->setName("ОЕПГ");

        $manager->persist($position);
        $manager->flush();
    }
}