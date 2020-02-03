<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class SecurityController extends AbstractController {

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    /**
     * @Route("/login", methods={"POST"})
     */
    public function login(Request $req) {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $req->get("email")]);

        if($user) {
            if($req->get("password") && $this->encoder->isPasswordValid($user, $req->get("password"))) {
                // Manually authenticate user in controller
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));

                $serializer = $this->container->get('serializer');
                $userJson = $serializer->serialize($user, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]);

                return new Response($userJson);
            }
        }

        return new Response(null, Response::HTTP_UNAUTHORIZED);
    }


    /**
     * @Route("/user/logged", methods={"GET"})
     */
    public function getLoggedUser(Request $req) {

        $user = $this->getUser();

        if($user) {
            $serializer = $this->container->get('serializer');
            $userJson = $serializer->serialize($user, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]);

            return new Response($userJson);
        }

        return new Response(null, Response::HTTP_UNAUTHORIZED); // return {} and status 401
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/user/all", methods={"GET"})
     */
    public function getAllUsers() {
        $allUsers = $this->getDoctrine()->getRepository(User::class)->findAll();

        $serializer = $this->container->get('serializer');
        $allUsersJson = $serializer->serialize($allUsers, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]);

        return new Response($allUsersJson);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/register", methods={"POST"})
     */
    public function register(Request $req, EntityManagerInterface $entityManager) {
        $email = $req->get("email");
        $password = $req->get("password");
        $roles = $req->get("roles");
        $firstName = $req->get("firstName");
        $secondName = $req->get("secondName");
        $lastName = $req->get("lastName");
        $region = $req->get("region");
        $subRegion = $req->get("subRegion");
        $city = $req->get("city");

        $userWithThisEmail = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $email]);
        if($userWithThisEmail) {
            return new Response(null, Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setEmail($email);

        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);

        $user->setRoles($roles);

        $user->setFirstName($firstName);
        $user->setSecondName($secondName);
        $user->setLastName($lastName);
        $user->setRegion($region);
        $user->setSubRegion($subRegion);
        $user->setCity($city);

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response($user);
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