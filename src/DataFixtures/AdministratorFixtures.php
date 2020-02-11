<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use App\Entity\City;
use App\Entity\Region;
use App\Entity\Role;
use App\Entity\SubRegion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdministratorFixtures extends Fixture implements DependentFixtureInterface {
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager) {
        $user = new Administrator();
        $user->setEmail("admin@admin.com");

        $password = $this->encoder->encodePassword($user, "pass");
        $user->setPassword($password);

        $roleAdmin = $manager->getRepository(Role::class)->findOneBy(["name" => "ROLE_ADMIN"]);
        $user->addRole($roleAdmin);

        $user->setFirstName("");
        $user->setSecondName("");
        $user->setLastName("");

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