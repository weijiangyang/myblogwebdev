<?php

namespace App\Controller;

use DateImmutableType;
use App\Entity\Comment;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    #[Route('/ajax/comments', name: 'comment_add')]
    public function add(EntityManagerInterface $em,UserRepository $userRepository,Request $request,CommentRepository $commentRepository, ArticleRepository $articleRepository): Response
    {
        $commentData = $request->request->all('comment');
        if(!$this->isCsrfTokenValid('comment-add',$commentData['_token'])){
            return $this->json([
                'code' => 'INVALID_CSRF_TOKEN'
            ],Response::HTTP_BAD_REQUEST);
        }
        $article = $articleRepository->findOneBy(['id'=>$commentData['article']]);
        if(!$article){
            return $this->json([
                'code' => 'ARTICLE_NONE_FOUND'
            ],Response::HTTP_BAD_REQUEST);
        }

        $user = $this->getUser();
        if(!$user){
            return $this->json([
                'code' => 'USER_NOT_AUTHENTICATED'

            ],Response::HTTP_BAD_REQUEST);
        }
        $comment = new Comment($article);
        $comment->setContent($commentData['content'])
                ->setUser($user)
                ->setCreatedAt(new \DateTimeImmutable());
        $em->persist($comment);
        $em->flush();
        $html = $this->renderView("comment/index.html.twig",[
            'comment' => $comment
        ]);

        return $this->json([
            'code' => 'COMMENT_ADDED_SUCCESSFULLY',
            'message' => $html,
            'nomberOfComments' => $commentRepository->count(['article'=>$article])
        ]);
        
        
    }
}
