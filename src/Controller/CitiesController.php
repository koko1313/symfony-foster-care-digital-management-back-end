<?php

namespace App\Controller;

use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CitiesController extends AbstractController
{

    /**
     * @Route("/city/all", methods={"GET"})
     */
    public function getAllCities(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $cities = $entityManager->getRepository(City::class)->findAll();

        $citiesJson = $serializer->serialize($cities, 'json');

        return new Response($citiesJson);
    }

}