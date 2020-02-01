<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\HardcoredData\HardcoredUsers;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController {

    /**
     * @Route("/login", methods={"POST"})
     */
    public function login(Request $req) {
        $response = new JsonResponse();

        $allUsers = HardcoredUsers::getAll();

        foreach ($allUsers as $user) {
            if($user["email"] == $req->get("email") && $user["password"] == $req->get("password")) {
                $response->setData($user);
                $response->setStatusCode(Response::HTTP_OK);
                return $response; // return logged user and status 200
            }
        }

        $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
        return $response; // return {} and status 401
    }

    /**
     * @Route("/logout", methods={"POST"})
     */
    public function logout() {
        $response = new JsonResponse();

        // do some logout logic ...

        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }

}