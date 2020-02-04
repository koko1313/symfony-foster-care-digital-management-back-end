<?php

namespace App\DataFixtures;

use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RegionFixtures extends Fixture {
    public function load(ObjectManager $manager) {
        $regions = [
            "Благоевград",
            "Бургас",
            "Варна",
            "Велико Търново",
            "Видин",
            "Враца",
            "Габрово",
            "Добрич",
            "Кърджали",
            "Кюстендил",
            "Ловеч",
            "Монтана",
            "Пазарджик",
            "Перник",
            "Плевен",
            "Пловдив",
            "Разград",
            "Русе",
            "Силистра",
            "Сливен",
            "Смолян",
            "София",
            "Стара Загора",
            "Търговище",
            "Хасково",
            "Шумен",
            "Ямбол"
        ];

        foreach($regions as $r) {
            $region = new Region();
            $region->setName($r);
            $manager->persist($region);
        }

        $manager->flush();
    }

    public function getDependencies() {
        return array(
            RoleFixtures::class,
        );
    }
}