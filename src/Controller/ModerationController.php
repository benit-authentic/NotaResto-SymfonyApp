<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\User;
use App\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModerationController extends AbstractController
{
/**
     * @Route("/moderation/reviews", name="moderation_reviews")
     */
    public function manageReviews(): Response
    {
        $reviews = $this->getDoctrine()->getRepository(Review::class)->findAll();

        return $this->render('moderation/reviews.html.twig', [
            'reviews' => $reviews,
        ]);
    }

    /**
     * @Route("/moderation/review/delete/{id}", name="review_delete", methods={"GET"})
     */
    public function deleteReview($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $review = $em->getRepository(Review::class)->find($id);

        if (!$review) {
            throw $this->createNotFoundException('No review found for id ' . $id);
        }

        $em->remove($review);
        $em->flush();

        return $this->redirectToRoute('moderation_reviews');
    }

    /**
     * @Route("/moderation/users", name="moderation_users")
     */
    public function manageUsers(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('moderation/users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/moderation/user/suspend/{id}", name="user_suspend", methods={"GET"})
     */
    public function suspendUser($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }

        // Example: Add suspended role or some other suspension logic
        $user->setRoles(['ROLE_SUSPENDED']);
        $em->flush();

        return $this->redirectToRoute('moderation_users');
    }

    /**
     * @Route("/moderation/user/ban/{id}", name="user_ban", methods={"GET"})
     */
    public function banUser($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('moderation_users');
    }

    /**
     * @Route("/moderation/restaurants", name="moderation_restaurants")
     */
    public function manageRestaurants(): Response
    {
        $restaurants = $this->getDoctrine()->getRepository(Restaurant::class)->findAll();

        return $this->render('moderation/restaurants.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    /**
     * @Route("/moderation/restaurant/delete/{id}", name="restaurant_delete", methods={"GET"})
     */
    public function deleteRestaurant($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $restaurant = $em->getRepository(Restaurant::class)->find($id);

        if (!$restaurant) {
            throw $this->createNotFoundException('No restaurant found for id ' . $id);
        }

        $em->remove($restaurant);
        $em->flush();

        return $this->redirectToRoute('moderation_restaurants');
    }}
