<?php

namespace App\Controller;

use App\Entity\Family;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Constants\Roles;

class FamilyController extends AbstractController {

    /**
     * @Route("/family/all", methods={"GET"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function getAll(SerializerInterface $serializer, EntityManagerInterface $entityManager) {
        $allFamilies = $entityManager->getRepository(Family::class)->findAll();

        $context = new SerializationContext();
        $context->setSerializeNull(true); // serialize null values too

        $allFamiliesJson = $serializer->serialize($allFamilies, 'json', $context);

        return new Response($allFamiliesJson);
    }

    /**
     * @Route("/family/delete/{id}", methods={"DELETE"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function delete($id, Request $req, EntityManagerInterface $entityManager) {
        $family = $entityManager->getRepository(Family::class)->find($id);

        if(!$family) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
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