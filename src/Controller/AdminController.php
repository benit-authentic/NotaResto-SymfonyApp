<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function manageUsers(EntityManagerInterface $em)
    {
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/users/{id}/promote", name="admin_promote_user")
     */
    public function promoteUser(User $user, EntityManagerInterface $em)
    {
        $user->setRoles(array_unique(array_merge($user->getRoles(), ['ROLE_MODERATEUR'])));
        $em->flush();

        return $this->redirectToRoute('admin_users');
    }
}