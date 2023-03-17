<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CommentService
{
    public $requestStack;
    public $commentRepository;
    public $paginator;
    public function __construct(PaginatorInterface $paginator, RequestStack $requestStack, CommentRepository $commentRepository)
    {
        $this->requestStack = $requestStack;
        $this->commentRepository = $commentRepository;
        $this->paginator = $paginator;
    }

    public function getPaginatedComments(?Article $article)
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = 2;
        $commentQuery = $this->commentRepository->findForPagination($article);
        return $this->paginator->paginate($commentQuery, $page, $limit);
    }
}
