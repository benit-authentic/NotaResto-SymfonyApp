<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\RestaurantPicture;
use App\Entity\Review;
use App\Repository\RestaurantRepository;
use App\Form\RestaurantType;
use App\Form\ReviewType;
use App\Form\RestaurantPictureType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class RestaurantController extends AbstractController
{
    private $restaurantRepository;
    private $entityManager;

    public function __construct(RestaurantRepository $restaurantRepository, EntityManagerInterface $entityManager)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Affiche la liste des restaurants
     * @Route("/restaurants", name="restaurant_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->restaurantRepository->findAll();
        $restaurants = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1), 
            6
        );

        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    /**
     * Affiche un restaurant
     * @Route("/restaurant/{restaurant}", name="restaurant_show", methods={"GET", "POST"}, requirements={"restaurant"="\d+"})
     */
    public function show(Request $request, Restaurant $restaurant, FileUploader $fileUploader): Response
    {
        $picture = new RestaurantPicture();
        $formPicture = $this->createForm(RestaurantPictureType::class, $picture);
        $formPicture->handleRequest($request);

        if ($formPicture->isSubmitted() && $formPicture->isValid()) {
            $file = $formPicture['filename']->getData();
            if ($file) {
                $filename = $fileUploader->upload($file);
                $picture->setFilename($filename);
                $picture->setRestaurant($restaurant);

                $this->entityManager->persist($picture);
                $this->entityManager->flush();

                return $this->redirectToRoute('restaurant_show', ['restaurant' => $restaurant->getId()]);
            }
        }

        $review = new Review();
        $formReview = $this->createForm(ReviewType::class, $review);
        $formReview->handleRequest($request);

        if ($formReview->isSubmitted() && $formReview->isValid()) {
            $review->setUser($this->getUser());
            $review->setRestaurant($restaurant);

            $this->entityManager->persist($review);
            $this->entityManager->flush();

            return $this->redirectToRoute('restaurant_show', ['restaurant' => $restaurant->getId()]);
        }

        return $this->render('restaurant/show.html.twig',  [
            'restaurant' => $restaurant,
            'formPicture' => $formPicture->createView(),
            'formReview' => $formReview->createView()
        ]);
    }

    /**
     * Affiche et gère le formulaire de création de restaurant
     * @Route("/restaurant/new", name="restaurant_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_RESTAURATEUR")
     */
    public function new(Request $request)
    {
        $restaurant = new Restaurant();

        $form = $this->createForm(RestaurantType::class, $restaurant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurant = $form->getData();
            $restaurant->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('restaurant_index');
        }

        return $this->render('restaurant/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Traite la requête d'un formulaire de création de restaurant
     * @Route("/restaurant", name="restaurant_create", methods={"POST"})
     */
    public function create()
    {
    }

    /**
     * Affiche le formulaire d'édition d'un restaurant (GET)
     * Traite le formulaire d'édition d'un restaurant (POST)
     * @Route("/restaurant/{restaurant}/edit", name="restaurant_edit", methods={"GET", "POST"})
     * @param Restaurant $restaurant
     */
    public function edit(Restaurant $restaurant)
    {
    }

    /**
     * Supprime un restaurant
     * @Route("/restaurant/{restaurant}", name="restaurant_delete", methods={"DELETE"})
     * @param Restaurant $restaurant
     */
    public function delete(Restaurant $restaurant)
    {
    }
}
