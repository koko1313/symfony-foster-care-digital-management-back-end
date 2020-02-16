<?php

namespace App\Controller;

use App\Constants\Positions;
use App\Entity\City;
use App\Entity\EmployeeOEPG;
use App\Entity\Position;
use App\Entity\Region;
use App\Entity\SubRegion;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Constants\Roles;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

        $allUsersJson = $serializer->serialize($allUsers, 'json');

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

        $userJson = $serializer->serialize($user, 'json');

        return new Response($userJson);
    }


    /**
     * @Route("/register", methods={"POST"})
     * @IsGranted(Roles::ROLE_ADMIN)
     */
    public function register(Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator) {
        $email = trim($req->get("email"));
        $password = trim($req->get("password"));
        $firstName = trim($req->get("firstName"));
        $secondName = trim($req->get("secondName"));
        $lastName = trim($req->get("lastName"));
        $regionId = trim($req->get("regionId"));
        $subRegionId = trim($req->get("subRegionId"));
        $cityId = trim($req->get("cityId"));

        $userWithThisEmail = $entityManager->getRepository(User::class)->findOneBy(["email" => $email]);

        if($userWithThisEmail) {
            return new Response("The email is already taken.", Response::HTTP_CONFLICT);
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

        $errors = $validator->validate($user);
        if(count($errors) > 0) {
            return new Response("All fields are required.", Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        $userJson = $serializer->serialize($user, 'json');
        return new Response($userJson);
    }


    /**
     * @Route("/update/{id}", methods={"PUT"})
     * @IsGranted(Roles::ROLE_ADMIN)
     */
    public function update($id, Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator) {
        $userId = trim($id);
        $email = trim($req->get("email"));
        $firstName = trim($req->get("firstName"));
        $secondName = trim($req->get("secondName"));
        $lastName = trim($req->get("lastName"));
        $regionId = trim($req->get("regionId"));
        $subRegionId = trim($req->get("subRegionId"));
        $cityId = trim($req->get("cityId"));

        $userWithThisEmail = $entityManager->getRepository(User::class)->findOneBy(["email" => $email]);

        if($userWithThisEmail && $userWithThisEmail->getId() != $id) {
            return new Response("The email is already taken.", Response::HTTP_CONFLICT);
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

        $errors = $validator->validate($user);
        if(count($errors) > 0) {
            return new Response("All fields are required.", Response::HTTP_BAD_REQUEST);
        }

        $entityManager->flush();

        $userJson = $serializer->serialize($user, 'json');

        return new Response($userJson);
    }

}