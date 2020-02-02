<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Dompdf\Dompdf;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends AbstractController {

    /**
     * @Route("/protected-test", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
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

    // ####################################################

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    /**
     * @Route("/login", methods={"POST"})
     */
    public function login(Request $req) {
        $response = new JsonResponse();

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $req->get("email")]);

        if($user) {
            if($req->get("password") && $this->encoder->isPasswordValid($user, $req->get("password"))) {
                // Manually authenticate user in controller
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));

                $response->setData([
                    "email" => $user->getEmail(),
                    "roles" => $user->getRoles(),
                ]);

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

        $this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();

        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }

}