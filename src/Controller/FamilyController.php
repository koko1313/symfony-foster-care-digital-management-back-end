<?php

namespace App\Controller;

use App\Entity\Family;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class FamilyController extends AbstractController {

    /**
     * @Route("/family/all", methods={"GET"})
     * @IsGranted("ROLE_OEPG")
     */
    public function getAll(SerializerInterface $serializer, EntityManagerInterface $entityManager) {
        $allFamilies = $entityManager->getRepository(Family::class)->findAll();

        $context = new SerializationContext();
        $context->setSerializeNull(true); // serialize null values too

        $allFamiliesJson = $serializer->serialize($allFamilies, 'json', $context);

        return new Response($allFamiliesJson);
    }

}