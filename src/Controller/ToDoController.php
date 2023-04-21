<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

class ToDoController extends AbstractController
{
    #[Route('/todo', name: 'todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        // Afficher notre tableau de todo
        // sinon je l'initialise puis j'affiche
        if (!$session->has('todos')) {
            $todos = [
                'achat'=> 'acheter clé usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mes examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash('info', "La liste des todos vient d'être initialisée" );
        }
        // si j'ai mon tableau de todo dans ma session je ne fais que l'afficher

        return $this->render('todo/index.html.twig');
    }
    #[Route('/todo/add/{name}/{content}', name: 'todo.add')]
    public function addTodo(Request $request, $name, $content): RedirectResponse {
        $session = $request->getSession();
        // Vérifier si j'ai mon tableau de todo dans la session
        if ($session->has('todos')) {
            //si oui
            // verifier si on a déja un todo avec le meme name
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                // si oui afficher erreur
                $this->addFlash('danger', "un todo de nom $name existe déjà" );
            } else {
                // sinon on l'ajoute et on affiche un msg de success
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', "un todo est ajouté avec succes" );
            }
        } else {
            //sinon
            //afficher une erreur et on va rediriger vers le controlleur initial : index
            $this->addFlash('danger', "La liste des todos n'est pas encore initialisée" );
        }
        return $this->redirectToRoute('todo');
    }
    #[Route('/todo/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse {
        $session = $request->getSession();
        // Vérifier si j'ai mon tableau de todo dans la session
        if ($session->has('todos')) {
            //si oui
            // verifier si on a déja un todo avec le meme name
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                // si oui afficher erreur
                $this->addFlash('danger', "un todo de nom $name n'existe pas" );
            } else {
                // sinon on l'ajoute et on affiche un msg de success
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', "un todo est modifié avec succes" );
            }
        } else {
            //sinon
            //afficher une erreur et on va rediriger vers le controlleur initial : index
            $this->addFlash('danger', "La liste des todos n'est pas encore initialisée" );
        }
        return $this->redirectToRoute('todo');
    }
    #[Route('/todo/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name) : RedirectResponse{
        $session = $request->getSession();
        // Vérifier si j'ai mon tableau de todo dans la session
        if ($session->has('todos')) {
            //si oui
            // verifier si on a déja un todo avec le meme name
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                // si oui afficher erreur
                $this->addFlash('danger', "un todo de nom $name n'existe pas" );
            } else {
                // sinon on l'ajoute et on affiche un msg de success
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('success', "un todo est supprimé avec succes" );
            }
        } else {
            //sinon
            //afficher une erreur et on va rediriger vers le controlleur initial : index
            $this->addFlash('danger', "La liste des todos n'est pas encore initialisée" );
        }
        return $this->redirectToRoute('todo');
    }
    #[Route('/todo/reset', name: 'todo.reset')]
    public function resetTodos(Request $request): RedirectResponse {
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('todo');
    }
}
