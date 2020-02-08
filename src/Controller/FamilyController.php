<?php

namespace App\Controller;

use App\Entity\Family;
use App\Helpers\Validator;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Constants\Roles;

/**
 * @Route("family", name="family_")
 */
class FamilyController extends AbstractController {

    /**
     * @Route("/all", methods={"GET"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function getAll(SerializerInterface $serializer, EntityManagerInterface $entityManager) {
        $allFamilies = $entityManager->getRepository(Family::class)->findAll();

        $allFamiliesJson = $serializer->serialize($allFamilies, 'json');

        return new Response($allFamiliesJson);
    }


    /**
     * @Route("/{id}", methods={"GET"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function getById($id, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $family = $entityManager->getRepository(Family::class)->find($id);

        if(!$family) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $familyJson = $serializer->serialize($family, 'json');

        return new Response($familyJson);
    }


    /**
     * @Route("/register", methods={"POST"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function register(Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $titular = $req->get("titular");
        $womanFirstName = $req->get("womanFirstName");
        $womanSecondName = $req->get("womanSecondName");
        $womanLastName = $req->get("womanLastName");
        $manFirstName = $req->get("manFirstName");
        $manSecondName = $req->get("manSecondName");
        $manLastName = $req->get("manLastName");
        $preferKidGender = $req->get("preferKidGender");
        $preferKidMinAge = $req->get("preferKidMinAge");
        $preferKidMaxAge = $req->get("preferKidMaxAge");
        $wardenId = $req->get("wardenId");

        if(Validator::checkEmptyFields([$titular, $womanFirstName, $womanSecondName, $womanLastName, $manFirstName, $manSecondName, $manLastName])) {
            return new Response("All fields are required.", Response::HTTP_BAD_REQUEST);
        }

        if($preferKidMinAge == "") $preferKidMinAge = null;
        if($preferKidMaxAge == "") $preferKidMaxAge = null;

        $family = new Family();
        $family->setTitular($titular);
        $family->setWomanFirstName($womanFirstName);
        $family->setWomanSecondName($womanSecondName);
        $family->setWomanLastName($womanLastName);
        $family->setManFirstName($manFirstName);
        $family->setManSecondName($manSecondName);
        $family->setManLastName($manLastName);
        $family->setPreferKidGender($preferKidGender);
        $family->setPreferKidMinAge($preferKidMinAge);
        $family->setPreferKidMaxAge($preferKidMaxAge);

        $entityManager->persist($family);
        $entityManager->flush();

        $familyJson = $serializer->serialize($family, 'json');

        return new Response($familyJson);
    }

    /**
     * @Route("/update/{id}", methods={"PUT"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function update($id, Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $titular = $req->get("titular");
        $womanFirstName = $req->get("womanFirstName");
        $womanSecondName = $req->get("womanSecondName");
        $womanLastName = $req->get("womanLastName");
        $manFirstName = $req->get("manFirstName");
        $manSecondName = $req->get("manSecondName");
        $manLastName = $req->get("manLastName");
        $preferKidGender = $req->get("preferKidGender");
        $preferKidMinAge = $req->get("preferKidMinAge");
        $preferKidMaxAge = $req->get("preferKidMaxAge");

        if(Validator::checkEmptyFields([$titular, $womanFirstName, $womanSecondName, $womanLastName, $manFirstName, $manSecondName, $manLastName])) {
            return new Response("All fields are required.", Response::HTTP_BAD_REQUEST);
        }

        if($preferKidMinAge == "") $preferKidMinAge = null;
        if($preferKidMaxAge == "") $preferKidMaxAge = null;

        $family = $entityManager->getRepository(Family::class)->find($id);

        $family->setTitular($titular);
        $family->setWomanFirstName($womanFirstName);
        $family->setWomanSecondName($womanSecondName);
        $family->setWomanLastName($womanLastName);
        $family->setManFirstName($manFirstName);
        $family->setManSecondName($manSecondName);
        $family->setManLastName($manLastName);
        $family->setPreferKidGender($preferKidGender);
        $family->setPreferKidMinAge($preferKidMinAge);
        $family->setPreferKidMaxAge($preferKidMaxAge);

        $entityManager->persist($family);
        $entityManager->flush();

        $familyJson = $serializer->serialize($family, 'json');

        return new Response($familyJson);
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function delete($id, Request $req, EntityManagerInterface $entityManager) {
        $family = $entityManager->getRepository(Family::class)->find($id);

        if(!$family) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($family);
        $entityManager->flush();

        // check if family was deleted
        $family = $entityManager->getRepository(Family::class)->find($id);
        if($family) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        return new Response(null);
    }

}