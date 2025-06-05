<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Comment;
use App\Enum\CommentStatus;
use App\Form\CommentType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/comment')]
final class CommentController extends AbstractController
{
    #[Route('/{id}', name: 'app_comment_add', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Book $book, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$book) {
            throw 'L\'ID d\'un livre doit être renseigné';
        }

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment, ['csrf_protection' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setStatus(CommentStatus::Pending);
            $comment->setBook($book);
            $comment->setCreatedAt(new DateTimeImmutable("now"));

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('app_book_show', ['id' => $book->getId()]);
        }

        return $this->render('comment/new.html.twig', [
            'book' => $book,
            'form' => $form
        ]);
    }
}
