<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Service\CommentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/article/{slug}', name: 'article_show')]
    public function show(?Article $article,CommentService $commentService): Response
    {
        if(!$article){
            return $this->redirectToRoute('app_home');
        }
        $comment = new Comment($article);
        $commentForm = $this->createForm(CommentType::class,$comment);
        $commentsPaginated = $commentService->getPaginatedComments($article);
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'form'=> $commentForm -> createView(),
            'commentsPaginated' => $commentsPaginated
        ]);
    }
}
