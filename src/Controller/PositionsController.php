<?php

namespace App\Controller;

use App\Entity\Position;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PositionsController extends AbstractController {

    /**
     * @Route("/position/all", methods={"GET"})
     */
    public function getAllPositions(SerializerInterface $serializer, EntityManagerInterface $entityManager) {
        $allPositions = $entityManager->getRepository(Position::class)->findAll();

        $allPositionsJson = $serializer->serialize($allPositions, 'json');

        return new Response($allPositionsJson);
    }

}