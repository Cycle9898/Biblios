<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Enum\CommentStatus;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_MODERATOR')]
#[Route('/admin/comment')]
final class CommentController extends AbstractController
{
    #[Route('', name: 'app_admin_comment_index', methods: ['GET'])]
    public function index(Request $request, CommentRepository $commentRepo): Response
    {
        $elementsPerPage = 5;

        $statusFilterValue = (string) $request->query->get('status');

        $commentsQuery = $commentRepo->createQueryBuilder('c');
        if ($statusFilterValue) {
            $commentsQuery->andWhere('c.status = :value')->setParameter(':value', $statusFilterValue);
        }

        $comments = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($commentsQuery),
            (int) $request->query->get('page', 1),
            $elementsPerPage
        );

        $statusesValuesAndLabels = CommentStatus::getValuesAndLabels();

        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comments,
            'element_per_page' => $elementsPerPage,
            'comment_statuses' => $statusesValuesAndLabels,
            'filter_value' => $statusFilterValue
        ]);
    }

    #[Route('/{id}', name: 'app_admin_comment_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Comment $comment): Response
    {
        return $this->render('admin/comment/show.html.twig', [
            'comment' => $comment
        ]);
    }

    #[Route('/{id}/validate', name: 'app_admin_comment_validate', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function validate(?Comment $comment, EntityManagerInterface $manager): Response
    {
        if (!$comment || $comment->getStatus()->value != "pending") {
            throw new Exception("Le commentaire ciblé est déjà validé ou n'existe pas", 404);
        }

        $comment->setStatus(CommentStatus::Published);
        $comment->setPublishedAt(new DateTimeImmutable("now"));

        $manager->persist($comment);
        $manager->flush();

        return $this->redirectToRoute('app_admin_comment_index');
    }

    #[Route('/{id}/edit', name: 'app_admin_comment_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(?Comment $comment, EntityManagerInterface $manager, Request $request): Response
    {
        if (!$comment) {
            throw new Exception("Le commentaire ciblé n'existe pas", 404);
        }

        $form = $this->createForm(CommentType::class, $comment, ['csrf_protection' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setStatus(CommentStatus::Moderated);
            $comment->setPublishedAt(new DateTimeImmutable("now"));

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('app_admin_comment_index');
        }

        return $this->render('admin/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_comment_delete', requirements: ['id' => '\d+'], methods: ['GET', 'DELETE'])]
    public function delete(?Comment $comment, EntityManagerInterface $entityManager): Response
    {
        if (!$comment || $comment->getStatus()->value != "pending") {
            throw new Exception("Le commentaire ciblé ne peut pas être supprimé ou n'existe pas", 404);
        }

        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->render('admin/comment/delete.html.twig', [
            'comment' => $comment
        ]);
    }
}
