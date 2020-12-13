<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin//users")
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/", name="users_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $q = $em
            ->createQuery('SELECT u FROM App\Entity\User u WHERE u.roles LIKE :role '
            )->setParameter('role', '%"ROLE_USER"%');

        $users = $q->getResult();

        return $this->render('users/index.html.twig', [
            'titre'=>'Abonnées',
            'soustitre'=>'Index',
            'lien'=>$this->generateUrl('users_index'),
            'users' => $users,
        ]);
    }
}
