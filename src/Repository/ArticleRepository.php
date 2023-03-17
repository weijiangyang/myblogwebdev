<?php

namespace App\Repository;

use DateTime;
use DateInterval;
use App\Entity\Article;
use Doctrine\ORM\Query;
use App\Entity\Category;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Config\TwigExtra\StringConfig;
use PHPUnit\Framework\Constraint\StringContains;
use Symfony\Component\Validator\Constraints\Date;
use Doctrine\ORM\Query\AST\Functions\DateAddFunction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findForPagination(?int $nbArticles, ?Category $category = null):Query
    {
        $qb = $this->createQueryBuilder('a')
                ->orderBy('a.createdAt','DESC');
        
        if($category){
            $qb->leftJoin('a.categories','c')
                ->where($qb->expr()->eq('c.id',':categoryId'))
                ->setParameter('categoryId',$category->getId());
        }
        if($nbArticles !== 0 && $nbArticles !== null){
            $qb->setMaxResults($nbArticles);
        }

        return $qb->getQuery();

    }

    public function findForArchive(?string $month = null):Query
    {
        $firstday = date("Y-m-01", strtotime($month));
        $lastday = date("Y-m-d", strtotime("$firstday +1 month"));
            
        
        
        return $qb = $this->createQueryBuilder('a')
                    ->where("a.createdAt BETWEEN :firstday AND :lastday ")
                    ->setParameter('firstday', $firstday)
        
                    ->setParameter('lastday', $lastday)
                    ->getQuery();
                    
        
    }

    public function getIndexQueryBuilder(int $userId): QueryBuilder
    {
    
        return  $this->createQueryBuilder('a')
                    ->where("a.author = :id ")
                    ->setParameter("id",$userId);
            

    }

}