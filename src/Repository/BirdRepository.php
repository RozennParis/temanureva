<?php

namespace App\Repository;

use App\Entity\Bird;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bird|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bird|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bird[]    findAll()
 * @method Bird[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BirdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bird::class);
    }

    /**
    * @return Bird[] Returns an array of Bird objects
     */
    public function findAllByVernacularName($term)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.vernacular_name LIKE :val')
            ->setParameter('val', $term)
            ->orderBy('b.vernacular_name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Bird
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField LIKE :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}*/
    public function nomOiseau($term)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->addSelect('b.vernacular_name')
            ->where('o.vernacular_name LIKE :term')
            ->setParameter('term', '%' . $term . '%');

        $arrayAss = $qb->getQuery()
            ->getArrayResult();

        $array = [];

        foreach ($arrayAss as $data) {
            $array[] = $data['vernacular_name'];
        }

        return $array;
    }
}