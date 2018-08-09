<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findById($id){
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $qb->getSingleResult();
    }

    public function findPublishedById($id){
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->andWhere('a.status = true')
            ->setParameter('id', $id)
            ->getQuery();

        return $qb->getSingleResult();
    }

    public function findWithOffset($offset, $limit){
        $qb = $this->createQueryBuilder('a')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('a.modification_date', 'DESC')
            ->getQuery();

        return $qb->getResult();
    }

    public function findPublishedWithOffset($offset, $limit){
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.status = true')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('a.publishing_date', 'DESC')
            ->getQuery();

        return $qb->getResult();
    }

//    /**
//     * @return Article[] Returns an array of Article objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
