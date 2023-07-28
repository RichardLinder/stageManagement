<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\InternRepository;
use App\Entity\Session;
use App\Entity\Intern;

class InternController extends AbstractController
{
   
    // fonction qui donne la liste des stagiaire
    #[Route('/intern', name: 'app_intern')]
    public function index(InternRepository $internRepository): Response
    {
        $interns = $internRepository->findBy([], ["name" => "ASC"]);
        return $this->render('intern/index.html.twig', [
            'interns' => $interns
        ]);
    }
    // détaille d'un stagiaire
    #[Route('/intern/{id}/show', name: 'showIntern')]
        public function showIntern(Intern $intern): Response 
        { 
            return $this->render
            (
                'intern/showIntern.html.twig', 
                [
                'intern' => $intern
                ]);
        }
        #[Route('/intern/newIntern', name: 'newIntern')]

        // fonction de creation d'un nouveau stagiaire 
    public function newIntern(Request $request, EntityManagerInterface $internManager ): Response
    {
        $Intern = new Intern();
        $form = $this->createForm(InternType::class, $intern);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) 
        {
            $intern= $form->getData();
            $internManager->persist($intern);
            $internManager->flush();


        }
        
        return $this->render
        (
            'intern/newIntern.htlm.twig', 
            [
                'newIntern' => $form,
            ]
        );
    }
    // Edition d'un stagiaire par id
    #[Route('/intern/{id}/editIntern', name: 'editIntern')]
    function editIntern(Intern $intern, Request $request, EntityManagerInterface $entityManager) : Returntype {
        
        $form = $this->createForm(InternType::class, $intern);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $intern = $form->getData();
            $entityManager->persist($intern);
            $entityManager->flush();

            return $this->redirectToRoute('app_intern');
        }

        return $this->render
        (
            'intern/newIntern.htlm.twig', 
            [
                'newIntern' => $form,
            ]
        );
        
    }
    
    #[Route('/intenr/{id}/delete', name: 'deleteIntern')]
    public function deleteIntern(Intern $intern, EntityManagerInterface $entityManager) 
    {
        // Prépare la suppression d'une instance de l'objet 

        $entityManager->remove($intern);

        // execucte le changement dans l'objet ( dans ce cas supression ) 
        $entityManager->flush();
        // retidirege vers la liste des ssesion
        return $this->redirectToRoute('app_intern');
    }


}