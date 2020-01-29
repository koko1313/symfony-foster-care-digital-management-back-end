<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChildrenController extends AbstractController {

    /**
     * @Route("/children", methods={"GET"})
     */
    public function getAll() {
        $response = new JsonResponse();
        $data = [
            [
                "egn" => "9701263209",
                "first_name" => "Иван",
                "second_name" => "Иванов",
                "last_name" => "Иванов",
                "sex" => "m",
                "region" => "Монтана",
                "municipality" => "Лом",
                "current_location" => "Брусарци"
            ],
            [
                "egn" => "9701263209",
                "first_name" => "Иван",
                "second_name" => "Иванов",
                "last_name" => "Иванов",
                "sex" => "m",
                "region" => "Монтана",
                "municipality" => "Лом",
                "current_location" => "Брусарци"
            ]
        ];
        $status = Response::HTTP_OK;

        $response->setData($data);
        $response->setStatusCode($status);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

}