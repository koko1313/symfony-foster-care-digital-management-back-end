<?php

namespace App\Controller;

use App\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegionsController extends AbstractController {

    /**
     * @Route("/region/all", methods={"GET"})
     */
    public function getAllRegions(EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $regions = $entityManager->getRepository(Region::class)->findAll();

        $regionsJson = $serializer->serialize($regions, 'json');

        return new Response($regionsJson);
    }

}