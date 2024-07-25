<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    /**
     * @Route("/user", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        $users = $this->userRepository->findAll();
        return $this->render('user/index.html.twig', [
        'users' => $users
    ]);
    }
}
