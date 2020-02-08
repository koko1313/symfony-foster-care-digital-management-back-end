<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Constants\Roles;

class UsersController extends SecurityController {

    /**
     * @Route("/user/logged", methods={"GET"})
     */
    public function getLogged(SerializerInterface $serializer) {
        $user = $this->getUser();

        if($user) {
            $userJson = $serializer->serialize($user, 'json');
            return new Response($userJson);
        }

        return new Response(null, Response::HTTP_UNAUTHORIZED); // return {} and status 401
    }

    /**
     * @Route("user/delete/{id}", methods={"DELETE"})
     * @Route("employee-oepg/delete/{id}", methods={"DELETE"})
     * @IsGranted(Roles::ROLE_ADMIN)
     */
    public function delete($id, Request $req, EntityManagerInterface $entityManager) {
        $user = $entityManager->getRepository(User::class)->find($id);

        if(!$user) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        // check if user was deleted
        $user = $entityManager->getRepository(User::class)->find($id);
        if($user) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        return new Response(null);
    }

}