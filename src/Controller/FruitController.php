<?php

// src/Controller/FruitController.php

namespace App\Controller;

use App\Entity\Fruit;
use App\Form\FruitFilterType;
use App\Repository\FruitRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

class FruitController extends AbstractController
{
    /**
     * @Route("/", name="fruit_index")
     */
    public function index(Request $request, FruitRepository $fruitRepository, PaginatorInterface $paginator): Response
    {

        $fruit = new Fruit();
        $form = $this->createForm(FruitFilterType::class, $fruit);


        $form->handleRequest($request);
        // dd(($form));
        $name = $request->get('name');
        $family = $request->get('family');

        $queryBuilder = $fruitRepository->searchByNameAndFamily($name, $family);
        $pagination = $paginator->paginate($queryBuilder, $request->query->getInt('page', 1), 10);


        $familyNames = $fruitRepository->getUniqueFamilyNames();

        return $this->render('fruit/index.html.twig', [
            'form' => $form->createView(),
            'fruits' => $pagination,
            'familyNames' => $familyNames,
        ]);
    }



    /**
     * @Route("/fruit/{id}/favorite", name="fruit_favorite")
     */
    public function favorite(Request $request, Fruit $fruit): Response
    {
        // add the fruit to favorites
        // ...
        // redirect to the favorites page
        return $this->redirectToRoute('fruit_favorites');
    }




    /**
     * @Route("/favorite-fruits", name="fruit_favorite")
     */
    public function favoriteFruits(FruitRepository $fruitRepository): Response
    {
        $favoriteFruits = $fruitRepository->findBy(['favorite' => true]);
        $totalNutrition = ['calories' => 0, 'fat' => 0, 'protein' => 0, 'carbs' => 0];

        foreach ($favoriteFruits as $fruit) {
            $totalNutrition['calories'] += $fruit->getCalories();
            $totalNutrition['fat'] += $fruit->getFat();
            $totalNutrition['protein'] += $fruit->getProtein();
            $totalNutrition['carbs'] += $fruit->getCarbohydrates();
        }

        return $this->render('fruit/favorites.html.twig', [
            'favoriteFruits' => $favoriteFruits,
            'totalNutrition' => $totalNutrition,
        ]);
    }


    /**
     * @Route("/api/fruits/{id}/favorite", name="api_fruits_favorite", methods={"PUT"})
     */
    public function toggleFavorite(Request $request, Fruit $fruit): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        // Check if fruit is already favorite
        if ($fruit->isFavorite()) {
            $fruit->setFavorite(false);
        } else {
            // Check if user already has 10 favorite fruits
            $favoriteFruits = $entityManager->getRepository(Fruit::class)->findBy(['favorite' => true]);
            if (count($favoriteFruits) >= 10) {
                return $this->json([
                    'success' => false,
                    'message' => 'You have already selected 10 favorite fruits.',
                ]);
            }

            $fruit->setFavorite(true);
        }

        $entityManager->persist($fruit);
        $entityManager->flush();

        return $this->json([
            'success' => true,
            'favorite' => $fruit->isFavorite(),
        ]);
    }
}
