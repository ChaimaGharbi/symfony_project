<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personne')]
class PersonneController extends AbstractController
{
    #[Route('/', name: 'personne.list')]
    public function index(ManagerRegistry $doctrine) : Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes =  $repository->findAll();
        return $this->render('personne/index.html.twig', ['personnes' => $personnes]);
    }

    #[Route('/{id<\d+>}', name: 'personne.detail')]
    /*public function detail(ManagerRegistry $doctrine, $id) : Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $personne =  $repository->find($id); */ //Or
    public function detail(Personne $personne = null) : Response
    {
        if(!$personne) {
            $this->addFlash('error', "La personne n'existe pas");
            return $this->redirectToRoute('personne.list');
        }
        return $this->render('personne/detail.html.twig', ['personne' => $personne]);
    }

    #[Route('/add', name: 'personne.add')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $personne = new Personne();
        $personne->setFirstname('Chaima');
        $personne->setName('Gharbi');
        $personne->setAge(21);
        // ceci marche pour modif ou creation
        $entityManager->persist($personne);

        /*$personne2 = new Personne();
        $personne2->setFirstname('Aasfour');
        $personne2->setName('Ghar');
        $personne2->setAge(2);
        // ceci marche pour modif ou creation
        $entityManager->persist($personne2);*/

        //execute la transaction
        $entityManager->flush();
        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    }
}
