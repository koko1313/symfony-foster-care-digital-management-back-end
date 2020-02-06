<?php

namespace App\Controller;

use App\Constants\Roles;
use App\Entity\Child;
use App\Entity\City;
use App\Entity\EmployeeOEPG;
use App\Entity\Position;
use App\Entity\Region;
use App\Entity\SubRegion;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController {

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }


    /**
     * @Route("/login", methods={"POST"})
     */
    public function login(Request $req, SerializerInterface $serializer, EntityManagerInterface $entityManager) {
        $user = $entityManager->getRepository(User::class)->findOneBy(["email" => $req->get("email")]);

        if($user) {
            if($req->get("password") && $this->encoder->isPasswordValid($user, $req->get("password"))) {
                // Manually authenticate user in controller
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));

                $userJson = $serializer->serialize($user, 'json');

                return new Response($userJson);
            }
        }

        return new Response(null, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @Route("/register", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function register(Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $email = $req->get("email");
        $password = $req->get("password");
        $positionId = $req->get("positionId");
        $firstName = $req->get("firstName");
        $secondName = $req->get("secondName");
        $lastName = $req->get("lastName");
        $regionId = $req->get("regionId");
        $subRegionId = $req->get("subRegionId");
        $cityId = $req->get("cityId");

        if($this->checkEmptyFields([$email, $password, $positionId, $firstName, $secondName, $lastName, $regionId, $subRegionId, $cityId])) {
            return new Response("All fields are required.", Response::HTTP_BAD_REQUEST);
        }

        $userWithThisEmail = $entityManager->getRepository(User::class)->findOneBy(["email" => $email]);

        if($userWithThisEmail) {
            return new Response(null, Response::HTTP_CONFLICT);
        }

        // get the position
        $position = $entityManager->getRepository(Position::class)->findOneBy(["id" => $positionId]);

        // check if position have dedicated Entity
        switch ($position->getRole()->getName()) {
            case Roles::ROLE_OEPG : { // if the role of the position is ROLE_OEPG
                $user = new EmployeeOEPG(); // create user, instance of EmployeeOEPG
                break;
            }
            default: {
                $user = new User();
                break;
            }
        }

        $user->setEmail($email);

        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);

        $user->setPosition($position);

        $role = $position->getRole();
        $user->addRole($role);

        $user->setFirstName($firstName);
        $user->setSecondName($secondName);
        $user->setLastName($lastName);

        $region = $entityManager->getRepository(Region::class)->findOneBy(["id" => $regionId]);
        $user->setRegion($region);

        $subRegion = $entityManager->getRepository(SubRegion::class)->findOneBy(["id" => $subRegionId]);
        $user->setSubRegion($subRegion);

        $city = $entityManager->getRepository(City::class)->findOneBy(["id" => $cityId]);
        $user->setCity($city);

        $entityManager->persist($user);

        $entityManager->flush();

        $userJson = $serializer->serialize($user, 'json');
        return new Response($userJson);
    }


    /**
     * @Route("/logout", methods={"POST"})
     */
    public function logout() {
        $this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();

        return new Response();
    }


    private function checkEmptyFields($fields) {
        foreach ($fields as $field) {
            if($field == null) {
                return true;
            }
        }
        return false;
    }

}