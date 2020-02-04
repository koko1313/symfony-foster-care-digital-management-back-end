<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Position;
use App\Entity\Region;
use App\Entity\Role;
use App\Entity\SubRegion;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
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
    public function login(Request $req, SerializerInterface $serializer, LoggerInterface $logger) {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $req->get("email")]);

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

        $userWithThisEmail = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $email]);
        if($userWithThisEmail) {
            return new Response(null, Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setEmail($email);

        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);

        $position = $this->getDoctrine()->getRepository(Position::class)->findOneBy(["id" => $positionId]);
        $user->setPosition($position);

        $role = $this->getDoctrine()->getRepository(Role::class)->findOneBy(["id" => $position->getRole()]);
        $user->addRole($role);


        $user->setFirstName($firstName);
        $user->setSecondName($secondName);
        $user->setLastName($lastName);

        $region = $this->getDoctrine()->getRepository(Region::class)->findOneBy(["id" => $regionId]);
        $user->setRegion($region);

        $subRegion = $this->getDoctrine()->getRepository(SubRegion::class)->findOneBy(["id" => $subRegionId]);
        $user->setSubRegion($subRegion);

        $city = $this->getDoctrine()->getRepository(City::class)->findOneBy(["id" => $cityId]);
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

}