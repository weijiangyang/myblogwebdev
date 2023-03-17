<?php 
namespace App\Service;

use DateTime;
use App\Entity\Category;
use App\Repository\OptionRepository;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\CssSelector\Parser\Handler\StringHandler;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\HttpFoundation\RequestStack;

class ArticleService
{
    public $requestStack;
    public $articleRepository;
    public $paginator;
    public $optionRepository;
    public function __construct(OptionRepository $optionRepository,PaginatorInterface $paginator,RequestStack $requestStack, ArticleRepository $articleRepository)
    {
        $this->requestStack = $requestStack;
        $this->articleRepository = $articleRepository;
        $this->paginator = $paginator;
        $this->optionRepository = $optionRepository;

        
    }

    public function getPaginatedArticles(?int $nbArticles,?Category $category)
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page',1);
        $limit = $this->optionRepository->getValue('blog_articles_limit');
        $articleQuery = $this->articleRepository->findForPagination($nbArticles,$category);
        return $this->paginator->paginate($articleQuery,$page,$limit);

    }

    public function getArchiveArticles(?string $month)
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = $this->optionRepository->getValue('blog_articles_limit');
        $articleQuery = $this->articleRepository->findForArchive($month);
        return $this->paginator->paginate($articleQuery, $page, $limit);

       
    }


}