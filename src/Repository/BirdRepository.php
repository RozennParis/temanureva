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
        $qb ->select('b.vernacularName', 'b.id') //'b.nameOrder' pour afficher le champ
            ->where('b.vernacularName LIKE :term') // ou bien machin, ou bien truc, ou bien bidule
            ->setParameter('term', '%' . $term . '%')
            ->orderBy('b.vernacularName', 'ASC');
        $birds = $qb->getQuery()
            ->getResult();
        $result = [];
        foreach ($birds as $bird) {
            $res['id'] = $bird['id'];
            $res['name'] = $bird['vernacularName'];
            //$res['image'] = $bird['image'];
            $result[] = $res;
        }

        return $result;
    }

    public function findByVernacularName()
    {
        return $qb = $this->createQueryBuilder('b')
            ->select('b')
            ->orderBy('b.vernacularName', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

    public function findByDescVernacularName()
    {
        return $qb = $this->createQueryBuilder('b')
            ->select('b')
            ->orderBy('b.vernacularName', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByNbObservation()
    {

    }

    public function findByDescNbObservation()
    {

    }

    public function getNumberBirds(){
        $qb = $this->createQueryBuilder('b');
        $qb->select($qb->expr()->count('b.id'));

        return $qb->getQuery()->getSingleScalarResult();
    }
}

