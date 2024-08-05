<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/user')]
class UserController extends AbstractController
{
    #[Route('', name: 'app_admin_user_index', methods: ['GET'])]
    public function index(Request $request, UserRepository $userRepo): Response
    {
        $users = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($userRepo->createQueryBuilder('u')),
            $request->query->get('page', 1),
            10
        );

        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/{id}', name: 'app_admin_user_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user
        ]);
    }
}
