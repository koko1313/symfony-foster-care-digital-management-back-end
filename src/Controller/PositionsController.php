<?php

namespace App\Controller;

use App\Entity\Position;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PositionsController extends AbstractController {

    /**
     * @Route("/position/all", methods={"GET"})
     */
    public function getAllPositions() {
        $allPositions = $this->getDoctrine()->getRepository(Position::class)->findAll();

        $serializer = $this->container->get('serializer');
        $allPositionsJson = $serializer->serialize($allPositions, 'json');

        return new Response($allPositionsJson);
    }

}