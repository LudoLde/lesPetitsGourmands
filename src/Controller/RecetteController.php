<?php

namespace App\Controller;

use \App\Repository\RecetteRepository;
use App\Form\IngredientType;
use App\Form\RecetteType;
use App\Entity\Recette;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class RecetteController extends AbstractController
{
    #[Route('/recette', name: 'recette.index', methods:['GET', 'POST'])]
    public function index(PaginatorInterface $paginator, Request $request, RecetteRepository $repository): Response
    {
        
        $recettes = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('recette/index.html.twig', [
            'recettes' => $recettes
        ]);
    }

    #[Route('/recette/creer', name: 'recette.creer', methods:['GET', 'POST'])]
    public function creer(Recette $recette, Request $request, EntityManagerInterface $manager): Response
    {
        
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $recette = $form->getData();

            $manager->persist($recette);
            $manager->flush();

            return $this->redirectToRoute('recette.index');
        }

        return $this->render('recette/creer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/recette/modifier/{id}', name: 'recette.modifier', methods:['GET', 'POST'])]
    public function modifier(Recette $recette, Request $request, EntityManagerInterface $manager, int $id): Response
    {
        
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $recette = $form->getData();

            $manager->persist($recette);
            $manager->flush();

            return $this->redirectToRoute('recette.index');
        }

        return $this->render('recette/creer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/recette/supprimer/{id}', name: 'recette.supprimer', methods:['GET', 'POST'])]
    public function supprimer(Recette $recette, EntityManagerInterface $manager): Response
    {
        
            $manager->remove($recette);
            $manager->flush();

            return $this->redirectToRoute('recette.index');
    }
}
