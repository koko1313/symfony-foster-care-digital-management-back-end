<?php

namespace App\Controller;

use App\Entity\Child;
use App\Entity\City;
use App\Entity\EmployeeOEPG;
use App\Entity\Region;
use App\Entity\SubRegion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Constants\Roles;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("child", name="child_")
 */
class ChildrenController extends AbstractController {

    /**
     * @Route("/all", methods={"GET"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function getAll(SerializerInterface $serializer, EntityManagerInterface $entityManager, UserInterface $user = null) {
        $allChildren = $entityManager->getRepository(Child::class)->findAllBelongToWarden($user->getId());

        $allChildrenJson = $serializer->serialize($allChildren, 'json');

        return new Response($allChildrenJson);
    }


    /**
     * @Route("/{id}", methods={"GET"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function getById($id, EntityManagerInterface $entityManager, SerializerInterface $serializer, UserInterface $user = null) {
        $child = $entityManager->getRepository(Child::class)->findByIdBelongToWarden($id, $user->getId());

        if(!$child) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $childJson = $serializer->serialize($child, 'json');

        return new Response($childJson);
    }


    /**
     * @Route("/register", methods={"POST"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function register(Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator) {
        $firstName = trim($req->get("firstName"));
        $secondName = trim($req->get("secondName"));
        $lastName = trim($req->get("lastName"));
        $egn = trim($req->get("egn"));
        $gender = trim($req->get("gender"));

        $regionId = trim($req->get("regionId"));
        $subRegionId = trim($req->get("subRegionId"));
        $cityId = trim($req->get("cityId"));
        $address = trim($req->get("address"));

        $wardenId = trim($req->get("wardenId"));

        $childWithThisEgn = $entityManager->getRepository(Child::class)->findOneBy(["egn" => $egn]);

        if($childWithThisEgn) {
            return new Response("Child with this EGN already exist.", Response::HTTP_CONFLICT);
        }

        $child = new Child();

        $child->setFirstName($firstName);
        $child->setSecondName($secondName);
        $child->setLastName($lastName);
        $child->setEgn($egn);
        $child->setGender($gender);

        $region = $entityManager->getRepository(Region::class)->find($regionId);
        $child->setRegion($region);

        $subRegion = $entityManager->getRepository(SubRegion::class)->find($subRegionId);
        $child->setSubRegion($subRegion);

        $city = $entityManager->getRepository(City::class)->find($cityId);
        $child->setCity($city);

        $child->setAddress($address);

        $warden = $entityManager->getRepository(EmployeeOEPG::class)->find($wardenId);
        $child->setWarden($warden);

        $errors = $validator->validate($child);
        if(count($errors) > 0) {
            return new Response((string) $errors, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($child);
        $entityManager->flush();

        $childJson = $serializer->serialize($child, 'json');

        return new Response($childJson);
    }


    /**
     * @Route("/update/{id}", methods={"PUT"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function update($id, Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator) {
        $firstName = trim($req->get("firstName"));
        $secondName = trim($req->get("secondName"));
        $lastName = trim($req->get("lastName"));
        $egn = trim($req->get("egn"));
        $gender = trim($req->get("gender"));

        $regionId = trim($req->get("regionId"));
        $subRegionId = trim($req->get("subRegionId"));
        $cityId = trim($req->get("cityId"));
        $address = trim($req->get("address"));

        $wardenId = trim($req->get("wardenId"));

        $childWithThisEgn = $entityManager->getRepository(Child::class)->findOneBy(["egn" => $egn]);

        if($childWithThisEgn && $childWithThisEgn->getId() != $id) {
            return new Response("Child with this EGN already exist.", Response::HTTP_CONFLICT);
        }

        $child = $entityManager->getRepository(Child::class)->find($id);

        if(!$child) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $child->setFirstName($firstName);
        $child->setSecondName($secondName);
        $child->setLastName($lastName);
        $child->setEgn($egn);
        $child->setGender($gender);
        $child->setAddress($address);

        $region = $entityManager->getRepository(Region::class)->find($regionId);
        $child->setRegion($region);

        $subRegion = $entityManager->getRepository(SubRegion::class)->find($subRegionId);
        $child->setSubRegion($subRegion);

        $city = $entityManager->getRepository(City::class)->find($cityId);
        $child->setCity($city);

        $errors = $validator->validate($child);
        if(count($errors) > 0) {
            return new Response("All fields are required.", Response::HTTP_BAD_REQUEST);
        }

        $entityManager->flush();

        $childJson = $serializer->serialize($child, 'json');

        return new Response($childJson);
    }


    /**
     * @Route("/delete/{id}", methods={"DELETE"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function delete($id, Request $req, EntityManagerInterface $entityManager) {
        $child = $entityManager->getRepository(Child::class)->find($id);

        if(!$child) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($child);
        $entityManager->flush();

        // check if child was deleted
        $child = $entityManager->getRepository(Child::class)->find($id);
        if($child) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        return new Response(null);
    }

}