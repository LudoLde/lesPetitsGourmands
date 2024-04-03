<?php

namespace App\Controller;

use \App\Repository\IngredientRepository;
use App\Form\IngredientType;
use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'ingredient.index', methods:['GET', 'POST'])]
    public function index(Paginatorinterface $paginator, IngredientRepository $repository, Request $request): Response
    {

        $ingredients = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredients
        ]);
    }

    #[Route('/ingredient/creer', name: 'ingredient.creer', methods:['GET', 'POST'])]
    public function creer(Ingredient $ingredient, EntityManagerInterface $manager, Request $request): Response
    {

        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            $manager->persist($ingredient);
            $manager->flush();

            return $this->redirectToRoute('ingredient.index');
        }
        

        return $this->render('ingredient/creer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/ingredient/modifier/{id}', name: 'ingredient.modifier')]
    public function modifier(Ingredient $ingredient, EntityManagerInterface $manager, Request $request, int $id): Response
    {

        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            $manager->persist($ingredient);
            $manager->flush();

            return $this->redirectToRoute('ingredient.index');
        }
        

        return $this->render('ingredient/modifier.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/ingredient/supprimer/{id}', name: 'ingredient.supprimer')]
    public function supprimer(Ingredient $ingredient, EntityManagerInterface $manager, int $id): Response
    {

            $manager->remove($ingredient);
            $manager->flush();

            return $this->redirectToRoute('ingredient.index');
    }
}
