<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Formation;
use App\Entity\Programme;
use App\Form\SessionType;
use App\Form\FormationType;
use App\Repository\SessionRepository;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SessionController extends AbstractController
{

//----------------------------------------------------------------------------------------- affichage

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
    
    // fonction qui donne la liste des formation

    #[Route('/formation', name: 'app_formation')]
    public function formation(FormationRepository $formationRepository): Response
    {
        $formations = $formationRepository->findAll();
        return $this->render('formation\index.htlm.twig', [
            'formations' => $formations
        ]);
    }
    // fonction qui donne les détaile d'une formation en ayant pour parametre l'id de la formation
    #[Route('/formation/{id}/show', name: 'show_formation')]
    public function showformation(Formation $formation): Response 
    {
        return $this->render
        (
            'formation\showformation.htlm.twig' ,           
            [
                'formation' => $formation
            ]
        );
    }
//-----------------------------------------------------------------------------------------creation

// fonction de creation de nouvelle entité de donné

    #[Route('/formation/newFormation', name: 'newFormation')]
    public function newformation(Request $request, EntityManagerInterface $formationManager): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) 
        {
            $formation= $form->getData();
            $formationManager->persist($formation);
            $formationManager->flush();


        }
        return $this->render
        (
            'formation/newFormation.htlm.twig', 
            [
                'newFormation' => $form,
            ]
        );
    }
    #[Route('/session/newSession', name: 'newSession')]
    public function newSession(Request $request, EntityManagerInterface $sessionManager ): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) 
        {
            $session= $form->getData();
            $sessionManager->persist($session);
            $sessionManager->flush();


        }


        return $this->render
        (
            'session/newSession.htlm.twig', 
            [
                'newSession' => $form,
            ]
        );
    }
    // #[Route('/session/{id}/editFormation', name: 'editFormation')]
    // function editFormation((Session $formation , Request $request, EntityManagerInterface $entityManager)) : Returntype {
        
    // }
    #[Route('/session/{id}/editSession', name: 'editSession')]
    function editSession(Session $session, Request $request, EntityManagerInterface $entityManager) : Returntype {
        
        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }

        return $this->render
        (
            'session/newSession.htlm.twig', 
            [
                'newSession' => $form,
            ]
        );
        
    }

    #[Route('/session/{id}/editFormation', name: 'editFormation')]
    function editFormation(Formation $formation, Request $request, EntityManagerInterface $entityManager) : Returntype {
        
        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $formation = $form->getData();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('app_formation');
        }

        return $this->render
        (
            'session/newSession.htlm.twig', 
            [
                'newSession' => $form,
            ]
        );
        
    }

//----------------------------------------------------------------------------------------- suppression



    #[Route('/session/{id}/delete', name: 'deleteSession')]
    public function deleteSession(Session $session, EntityManagerInterface $entityManager) 
    {
        // Prépare la suppression d'une instance de l'objet 

        $entityManager->remove($session);

        // execucte le changement dans l'objet ( dans ce cas supression ) 
        $entityManager->flush();
        // retidirege vers la liste des ssesion
        return $this->redirectToRoute('app_session');
    }

    
    #[Route('/session/{id}/delete', name: 'deleteFormation')]
    public function deleteFormation(Formation $formation, EntityManagerInterface $entityManager) 
    {
        // Prépare la suppression d'une instance de l'objet 

        $entityManager->remove($formation);

        // execucte le changement dans l'objet ( dans ce cas supression ) 
        $entityManager->flush();
        // retidirege vers la liste des ssesion
        return $this->redirectToRoute('app_formation');
    }
}