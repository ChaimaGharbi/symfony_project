<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request): Response
    {
        // php : session_start()
        $session = $request->getSession();

        if ($session->has('nbVisite')) {
            $nbreVisite = $session->get('nbVisite') + 1;
        } else {
            $nbreVisite = 1;
        }
        $session->set('nbVisite', $nbreVisite);
        echo $nbreVisite;
        return $this->render('session/index.html.twig');
    }
}
