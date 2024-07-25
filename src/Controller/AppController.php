<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class AppController extends AbstractController
{
    private $restaurantRepository;
    private $reviewRepository;

    public function __construct(RestaurantRepository $restaurantRepository, ReviewRepository $reviewRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * @Route("/", name="app_index", methods={"GET"})
     */
    public function index(): Response
    {

    $tenBestRestaurantsId = $this->reviewRepository->findBestTenRatings();
    $tenBestRestaurants = array_map(function($data) {
        return $this->restaurantRepository->find($data['restaurantId']);
    }, $tenBestRestaurantsId);

    return $this->render('app/index.html.twig', [
        'restaurants' => $tenBestRestaurants,
    ]);
    
    }

    /**
     * @Route("/search", name="app_search", methods={"GET"})
     */
    public function search(Request $request, PaginatorInterface $paginator, RestaurantRepository $restaurantRepository)
    {
        // Récupère l'input de recherche du formulaire, le name=zipcode
        $searchZipcode = $request->query->get('zipcode');

        // Recherche des restaurants par code postal
        $query = $restaurantRepository->searchByZipcode($searchZipcode);

        // Utilisation du service de pagination
        $pagination = $paginator->paginate(
            $query, // Query à paginer
            $request->query->getInt('page', 1), // Numéro de la page, par défaut 1
            10 // Nombre d'éléments par page
        );

        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $pagination,
        ]);
    }

}
