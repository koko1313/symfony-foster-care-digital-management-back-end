<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Region;
use App\Entity\SubRegion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CityFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
        $cities = [
            "София"
        ];

        foreach($cities as $c) {
            $city = new City();
            $city->setName($c);

            $sofiaSubRegion = $manager->getRepository(SubRegion::class)->findOneBy(["name" => "София"]);
            $city->setSubRegion($sofiaSubRegion);

            $region = $manager->getRepository(Region::class)->findOneBy(["name" => "София"]);
            $city->setRegion($region);

            $manager->persist($city);
        }

        $manager->flush();
    }

    public function getDependencies() {
        return array(
            SubRegionFixtures::class,
        );
    }
}