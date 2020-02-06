<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Region;
use App\Entity\Role;
use App\Entity\SubRegion;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface {
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setEmail("admin@admin.com");

        $password = $this->encoder->encodePassword($user, "pass");
        $user->setPassword($password);

        $roleAdmin = $manager->getRepository(Role::class)->findOneBy(["name" => "ROLE_ADMIN"]);
        $user->addRole($roleAdmin);

        $user->setFirstName("");
        $user->setSecondName("");
        $user->setLastName("");

        $sofiaRegion = $manager->getRepository(Region::class)->findOneBy(["name" => "София"]);
        $user->setRegion($sofiaRegion);

        $sofiaSubRegion = $manager->getRepository(SubRegion::class)->findOneBy(["name" => "София"]);
        $user->setSubRegion($sofiaSubRegion);

        $sofiaCity = $manager->getRepository(City::class)->findOneBy(["name" => "София"]);
        $user->setCity($sofiaCity);

        $manager->persist($user);

        $manager->flush();
    }

    public function getDependencies() {
        return array(
            RoleFixtures::class,
            RegionFixtures::class,
            SubRegionFixtures::class,
            CityFixtures::class,
        );
    }
}