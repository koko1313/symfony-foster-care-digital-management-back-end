<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\ENUM\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture {
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setEmail("admin@admin.com");

        $password = $this->encoder->encodePassword($user, "pass");
        $user->setPassword($password);

        $user->setRoles([Roles::ROLE_ADMIN]);

        $user->setFirstName("");
        $user->setSecondName("");
        $user->setLastName("");
        $user->setRegion("");
        $user->setSubRegion("");
        $user->setCity("");

        $manager->persist($user);

        $manager->flush();
    }
}