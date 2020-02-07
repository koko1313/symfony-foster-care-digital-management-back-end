<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Constants\Roles;

class TestController extends AbstractController {

    /**
     * @Route("/protected-test", methods={"GET", "POST"})
     * @IsGranted(Roles::ROLE_ADMIN)
     */
    public function sad() {
        return new Response("assda");
    }

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

}