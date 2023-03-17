<?php

namespace App\Repository;

use App\Entity\Option;
use Doctrine\DBAL\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Option>
 *
 * @method Option|null find($id, $lockMode = null, $lockVersion = null)
 * @method Option|null findOneBy(array $criteria, array $orderBy = null)
 * @method Option[]    findAll()
 * @method Option[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Option::class);
    }

    
    public function findAllForTwig()
    {
        return $this->createQueryBuilder('o','o.name')
                ->orderBy('o.name')
                ->getQuery()
                ->getArrayResult();
    }

    public function getValue(string $name):mixed
    {
        try {
          return $this->createQueryBuilder('o')
                ->select('o.value')
                ->where('o.name = :name')
                ->setParameter('name',$name)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException | NonUniqueResultException ) {
            return null;
        }
    }

    public function getIndexQueryBuilder():QueryBuilder
    {
        return $this->createQueryBuilder('o')
                    ->where('o.type IS NOT NULL');
    }

}
