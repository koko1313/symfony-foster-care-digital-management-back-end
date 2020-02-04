<?php

namespace App\DataFixtures;

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

        $user->addRole($this->getReference(RoleFixtures::ROLE_ADMIN_REFERENCE));

        $user->setFirstName("");
        $user->setSecondName("");
        $user->setLastName("");
        $user->setRegion("");
        $user->setSubRegion("");
        $user->setCity("");

        $manager->persist($user);

        $manager->flush();
    }

    public function getDependencies() {
        return array(
            RoleFixtures::class,
        );
    }
}