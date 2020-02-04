<?php

namespace App\Controller;

use App\Entity\User;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UsersController extends AbstractController {

    /**
     * @Route("/user/logged", methods={"GET"})
     */
    public function getLoggedUser(SerializerInterface $serializer) {
        $user = $this->getUser();

        if($user) {
            $userJson = $serializer->serialize($user, 'json');
            return new Response($userJson);
        }

        return new Response(null, Response::HTTP_UNAUTHORIZED); // return {} and status 401
    }


    /**
     * @Route("/user/all", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function getAllUsers(SerializerInterface $serializer) {
        $allUsers = $this->getDoctrine()->getRepository(User::class)->findAll();

        $allUsersJson = $serializer->serialize($allUsers, 'json');

        return new Response($allUsersJson);
    }

}