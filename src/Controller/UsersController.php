<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Region;
use App\Entity\SubRegion;
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
    public function getAllUsers(SerializerInterface $serializer, EntityManagerInterface $entityManager) {
        $allUsers = $entityManager->getRepository(User::class)->findAll();

        $context = new SerializationContext();
        $context->setSerializeNull(true); // serialize null values too

        $allUsersJson = $serializer->serialize($allUsers, 'json', $context);

        return new Response($allUsersJson);
    }


    /**
     * @Route("/user/{id}", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function getUserById($id, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $user = $entityManager->getRepository(User::class)->find($id);

        if(!$user) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $context = new SerializationContext();
        $context->setSerializeNull(true); // serialize null values too

        $userJson = $serializer->serialize($user, 'json', $context);

        return new Response($userJson);
    }


    /**
     * @Route("/user/update", methods={"PUT"})
     */
    public function update(Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $userId = $req->get("userId");
        $email = $req->get("email");
        $firstName = $req->get("firstName");
        $secondName = $req->get("secondName");
        $lastName = $req->get("lastName");
        $regionId = $req->get("regionId");
        $subRegionId = $req->get("subRegionId");
        $cityId = $req->get("cityId");

        $user = $entityManager->getRepository(User::class)->find($userId);

        if(!$user) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setSecondName($secondName);
        $user->setLastName($lastName);

        $region = $entityManager->getRepository(Region::class)->find($regionId);
        $user->setRegion($region);

        $subRegion = $entityManager->getRepository(SubRegion::class)->find($subRegionId);
        $user->setSubRegion($subRegion);

        $city = $entityManager->getRepository(City::class)->find($cityId);
        $user->setCity($city);

        $entityManager->flush();

        $userSerialized = $serializer->serialize($user, 'json');

        return new Response($userSerialized);
    }


    /**
     * @Route("/user/delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteUser(Request $req, EntityManagerInterface $entityManager) {
        $userId = $req->get("userId");

        $user = $entityManager->getRepository(User::class)->find($userId);

        if(!$user) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        // check if user was deleted
        $user = $entityManager->getRepository(User::class)->find($userId);
        if($user) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        return new Response(null);
    }

}