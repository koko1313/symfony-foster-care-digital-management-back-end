<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        $response = new JsonResponse();

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $req->get("email")]);

        if($user) {
            if($req->get("password") && $this->encoder->isPasswordValid($user, $req->get("password"))) {
                // Manually authenticate user in controller
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));

                $response->setData([
                    "email" => $user->getEmail(),
                    "roles" => $user->getRoles(),
                ]);

                $response->setStatusCode(Response::HTTP_OK);
                return $response; // return logged user and status 200
            }
        }

        $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
        return $response; // return {} and status 401
    }


    /**
     * @Route("/register", methods={"POST"})
     */
    public function register(Request $req, EntityManagerInterface $entityManager) {
        $email = $req->get("email");
        $password = $req->get("password");
        $roles = explode(",", $req->get("roles"));

        $response = new JsonResponse();

        $user = new User();
        $user->setEmail($email);

        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);

        $user->setRoles($roles);

        $user->setFirstName("");
        $user->setSecondName("");
        $user->setLastName("");
        $user->setRegion("");
        $user->setSubRegion("");
        $user->setCity("");

        $entityManager->persist($user);

        $entityManager->flush();

        return $response;
    }


    /**
     * @Route("/logout", methods={"POST"})
     */
    public function logout() {
        $response = new JsonResponse();

        $this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();

        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }

}