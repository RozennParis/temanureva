<?php

namespace App\Repository;

use App\Entity\Demand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Demand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demand[]    findAll()
 * @method Demand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Demand::class);
    }

    public function findById($id){
        $qb = $this->createQueryBuilder('d')
            ->andWhere('d.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $qb->getSingleResult();
    }

    public function findWithOffset($offset, $limit){
        $qb = $this->createQueryBuilder('d')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('d.submit_date', 'DESC')
            ->getQuery();

        return $qb->getResult();
    }

    public function getNumberDemand(){
        $qb = $this->createQueryBuilder('d');
        $qb->select($qb->expr()->count('d.id'));

        return $qb->getQuery()->getSingleScalarResult();
    }

//    /**
//     * @return Demand[] Returns an array of Demand objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Demand
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
