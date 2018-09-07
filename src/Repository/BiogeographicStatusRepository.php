<?php

namespace App\Repository;

use App\Entity\BiogeographicStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BiogeographicStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method BiogeographicStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method BiogeographicStatus[]    findAll()
 * @method BiogeographicStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BiogeographicStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BiogeographicStatus::class);
    }

//    /**
//     * @return BiogeographicStatus[] Returns an array of BiogeographicStatus objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BiogeographicStatus
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
