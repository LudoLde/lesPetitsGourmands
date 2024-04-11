<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ingredient;

class DataController extends AbstractController
{
    #[Route('/data', name: 'app_data', methods:['GET'])]
    public function index(IngredientRepository $repository): JsonResponse
    {   
        $ingredients = $repository->findAll();

        $dataIngredient = [];
        foreach ($ingredients as $ingredient) {
            $dataIngredient [] = [
                'id' => $ingredient->getID(),
                'nom' => $ingredient->getNom(),
                'type' => $ingredient->getType(),
                'createdAt' => $ingredient->getCreatedAt(),
            ];
        }
        return new JsonResponse($dataIngredient);
    }

    #[Route('/data/create', name: 'data.create')]
    public function createData(Request $request, EntityManagerInterface $manager): JsonResponse
    {   

        
        $dataCreateIngredient = json_decode($request->getContent(), true);
            $ingredient = new Ingredient();
             $ingredient->setNom($dataCreateIngredient[('nom')])
                        ->setType($dataCreateIngredient[('type')]);
           
            $manager->persist($ingredient);
            $manager->flush();

        return new JsonResponse($dataCreateIngredient);
    }

    #[Route('/data/update/{id}', name: 'data.update')]
    public function updateData(Request $request, EntityManagerInterface $manager, IngredientRepository $repository, int $id): JsonResponse
    {   

        $ingredient = $repository->find($id);
        if(!$ingredient){
            return new JsonResponse (['message: pas d\'ingrédient trouvé'], 404);
        }
        
        $dataCreateIngredient = json_decode($request->getContent(), true);

        if(isset($dataCreateIngredient['type'])){
            $ingredient->setType($dataCreateIngredient[('type')]);
        }
             $ingredient->setNom($dataCreateIngredient[('nom')]);
           
            $manager->persist($ingredient);
            $manager->flush();

        return new JsonResponse($dataCreateIngredient);
    }

    #[Route('/data/delete/{id}', name: 'data.delete')]
    public function dataDelete(EntityManagerInterface $manager, Ingredient $ingredient): JsonResponse
    {
        $manager->remove($ingredient);
        $manager->flush();

        return new JsonResponse(['success: ingrédient supprimé']);
    }
}
