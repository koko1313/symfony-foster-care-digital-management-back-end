<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        $context = new SerializationContext();
        $context->setSerializeNull(true); // serialize null values too

        $allUsersJson = $serializer->serialize($allUsers, 'json', $context);

        return new Response($allUsersJson);
    }


    /**
     * @Route("/user/delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteUser(Request $req, EntityManagerInterface $entityManager) {
        $userId = $req->get("userId");

        $user = $this->getDoctrine()->getRepository(User::class)->find($userId);

        if(!$user) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        // check if user was deleted
        $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
        if($user) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        return new Response(null);
    }

}