<?php

namespace App\Controller;

use App\Entity\SubRegion;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubRegionsController extends AbstractController {

    /**
     * @Route("/sub-region/all", methods={"GET"})
     */
    public function getAllSubRegions(EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $subRegions = $entityManager->getRepository(SubRegion::class)->findAll();

        $subRegionsJson = $serializer->serialize($subRegions, 'json');

        return new Response($subRegionsJson);
    }

}