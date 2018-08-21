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
        $qb = $this->createQueryBuilder('b');
        $qb ->select('b.vernacularName', 'b.lbName', 'b.id')
            ->where('b.vernacularName LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->orderBy('b.vernacularName', 'ASC');
        $arrayAss = $qb->getQuery()
            ->getResult();
        $array = [];
        foreach ($arrayAss as $data) {
            $array[] = $data['vernacularName'];
        }
        return $array;
    }

    public function findByVernacularName()
    {
        return $qb = $this->createQueryBuilder('b')
            ->select('b')
            ->orderBy('b.vernacularName', 'ASC')
            ->getQuery()
            ->getResult();

    }
}

