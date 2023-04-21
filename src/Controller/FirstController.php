<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    /*/**
     * @return Response
     * @Return /first
     */
    public function index(): Response
    {
        /*return new Response(
            "<head><title>Hello World!</title></head>
                    <body><h1>Hello Symfony Project!!</h1></body>"
        );*/
        // chercher de la bd les users
        return $this->render('first/index.html.twig', [
            'name' => 'Gharbi',
            'firstname' => 'Chaima'
        ]);
    }

    #[Route('/sayHello', name: 'Say_Hello')]
    public function sayHello(): Response
    {
        $rand = rand(0, 10);
        if ($rand == 3) {
            // pour envoyer vers cette route et même changer le url
            //return $this->redirectToRoute('app_first');
            // pour envoyer vers une autre methode du controlleur ou mm un autre controlleur:
            return $this->forward('App\Controller\FirstController::index');
        }
        return $this->render('first/sayHello.html.twig', [
            'rand' => $rand
        ]);
    }

    #[Route('/HelloTo/{name}', name: 'HelloTo')]
    public function Hello(Request $request, $name): Response
    {
        dd($request);
        return $this->render('first/index.html.twig', [
            'name'=> $name
    ]);
    }

    #[Route(/*'multi/{entier1}/{entier2}', name: 'multiplication', requirements: ['entier1' => '\d+', 'entier2' => '\d+']*/
            'multi/{entier1<\d+>}/{entier2<\d+>}', name: 'multiplication')]
    public function multiplication($entier1, $entier2) {
        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");
    }
}
