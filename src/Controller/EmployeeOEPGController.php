<?php

namespace App\Controller;

use App\Constants\Positions;
use App\Entity\City;
use App\Entity\EmployeeOEPG;
use App\Entity\Position;
use App\Entity\Region;
use App\Entity\SubRegion;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Constants\Roles;

/**
 * @Route("employee-oepg", name="employee-oepg_")
 */
class EmployeeOEPGController extends UsersController {

    /**
     * @Route("/all", methods={"GET"})
     * @IsGranted(Roles::ROLE_ADMIN)
     */
    public function getAll(SerializerInterface $serializer, EntityManagerInterface $entityManager) {
        $allUsers = $entityManager->getRepository(EmployeeOEPG::class)->findAll();

        $context = new SerializationContext();
        $context->setSerializeNull(true); // serialize null values too

        $allUsersJson = $serializer->serialize($allUsers, 'json', $context);

        return new Response($allUsersJson);
    }


    /**
     * @Route("/{id}", methods={"GET"})
     * @IsGranted(Roles::ROLE_ADMIN)
     */
    public function getById($id, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $user = $entityManager->getRepository(EmployeeOEPG::class)->find($id);

        if(!$user) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $context = new SerializationContext();
        $context->setSerializeNull(true); // serialize null values too

        $userJson = $serializer->serialize($user, 'json', $context);

        return new Response($userJson);
    }


    /**
     * @Route("/register", methods={"POST"})
     * @IsGranted(Roles::ROLE_ADMIN)
     */
    public function register(Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $email = $req->get("email");
        $password = $req->get("password");
        $firstName = $req->get("firstName");
        $secondName = $req->get("secondName");
        $lastName = $req->get("lastName");
        $regionId = $req->get("regionId");
        $subRegionId = $req->get("subRegionId");
        $cityId = $req->get("cityId");

        if($this->checkEmptyFields([$email, $password, $firstName, $secondName, $lastName, $regionId, $subRegionId, $cityId])) {
            return new Response("All fields are required.", Response::HTTP_BAD_REQUEST);
        }

        $userWithThisEmail = $entityManager->getRepository(EmployeeOEPG::class)->findOneBy(["email" => $email]);

        if($userWithThisEmail) {
            return new Response(null, Response::HTTP_CONFLICT);
        }

        $user = new EmployeeOEPG();

        $user->setEmail($email);

        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);

        $position = $entityManager->getRepository(Position::class)->findOneBy(["name" => Positions::POSITION_OEPG]);
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
     * @Route("/update/{id}", methods={"PUT"})
     * @IsGranted(Roles::ROLE_ADMIN)
     */
    public function update($id, Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $userId = $id;
        $email = $req->get("email");
        $firstName = $req->get("firstName");
        $secondName = $req->get("secondName");
        $lastName = $req->get("lastName");
        $regionId = $req->get("regionId");
        $subRegionId = $req->get("subRegionId");
        $cityId = $req->get("cityId");

        if($this->checkEmptyFields([$email, $firstName, $secondName, $lastName, $regionId, $subRegionId, $cityId])) {
            return new Response("All fields are required.", Response::HTTP_BAD_REQUEST);
        }

        $user = $entityManager->getRepository(EmployeeOEPG::class)->find($userId);

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

        $userJson = $serializer->serialize($user, 'json');

        return new Response($userJson);
    }

}