<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\HardcoredData\HardcoredUsers;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController {

    /**
     * @Route("/users", methods={"GET"})
     */
    public function getAll() {
        $response = new JsonResponse();
        $data = HardcoredUsers::getAll();
        $status = Response::HTTP_OK;

        $response->setData($data);
        $response->setStatusCode($status);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

}