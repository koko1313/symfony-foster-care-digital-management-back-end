<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController {

    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }


    /**
     * @Route("/login", methods={"POST"})
     */
    public function login(Request $req, SerializerInterface $serializer, EntityManagerInterface $entityManager) {
        $email = $req->get("email");
        $password = $req->get("password");

        $user = $entityManager->getRepository(User::class)->findOneBy(["email" => $email]);
        $entityManager->close();

        if($user) {
            // get the concrete user, based on $user class name - get_class($user)
            $concreteUser = $entityManager->getRepository(get_class($user))->findOneBy(["email" => $email]);

            if($password && $this->encoder->isPasswordValid($concreteUser, $password)) {
                // Manually authenticate user in controller
                $token = new UsernamePasswordToken($concreteUser, $concreteUser->getPassword(), 'main', $concreteUser->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));

                $userJson = $serializer->serialize($concreteUser, 'json');

                return new Response($userJson);
            }
        }

        return new Response(null, Response::HTTP_UNAUTHORIZED);
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