<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_book_index', methods: ['GET'])]
    public function index(Request $request, BookRepository $bookRepo): Response
    {
        $books = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($bookRepo->createQueryBuilder('b')),
            $request->query->get('page', 1),
            20
        );

        return $this->render('book/index.html.twig', [
            'books' => $books
        ]);
    }
}
