<?php

namespace App\DataFixtures;

use App\Entity\Region;
use App\Entity\SubRegion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SubRegionFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
        $subRegions = [
            "София"
        ];

        foreach($subRegions as $r) {
            $subRegion = new SubRegion();
            $subRegion->setName($r);

            $sofiaRegion = $manager->getRepository(Region::class)->findOneBy(["name" => "София"]);
            $subRegion->setRegion($sofiaRegion);

            $manager->persist($subRegion);
        }

        $manager->flush();
    }

    public function getDependencies() {
        return array(
            RegionFixtures::class,
        );
    }
}