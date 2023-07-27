<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Formation;
use App\Entity\Programme;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FormationRepository;


class SessionController extends AbstractController
{

// fonction qui donne la liste des session
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findBy([], ["startingDate" => "ASC"]);
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions
        ]);
    }

    // fonction qui donne les détaile d'une session en ayant pour parametre l'id de la session

    #[Route('/session/{id}/show', name: 'show_session')]
    public function showSession(Session $session): Response 
    { 
        return $this->render
        (
            'session/showSession.html.twig', 
            [
            'session' => $session
            ]
        );
    }    
    #[Route('/formation', name: 'app_formation')]
    public function formation(FormationRepository $formationRepository): Response
    {
        $formations = $formationRepository->findAll();
        return $this->render('formation\index.htlm.twig', [
            'formations' => $formations
        ]);
    }
    #[Route('/formation/{id}/show', name: 'show_formation')]
    public function showformation(Formation $formation): Response 
    {
        return $this->render
        (
            'formation\showformation.htlm.twig' ,           [
            'formation' => $formation
            ]
        );
    }


    #[Route('/formation', name: 'app_formation')]
    public function new(Request $request): Response
    {
        $task = new Task();
        // ...

        $form = $this->createForm(TaskType::class, $task);

        return $this->render('task/new.html.twig', [
            'form' => $form,
        ]);
    }
  
}