<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\HardcoredData\HardcoredUsers;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;

class LoginController extends AbstractController {

    /**
     * @Route("/pdf", methods={"GET"})
     */
    public function pdf() {
        $dompdf = new Dompdf();

        $html = $this->renderView('DocumentTemplates/ExampleDocument.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();

        $publicDirectory = $this->getParameter('kernel.project_dir') . '/public/documents';
        $pdfFilepath =  $publicDirectory . '/mypdf.pdf';

        file_put_contents($pdfFilepath, $output);

        return new JsonResponse(null, 200);
    }


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