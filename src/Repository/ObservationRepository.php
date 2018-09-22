<?php

namespace App\Repository;

use App\Entity\Observation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Observation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Observation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Observation[]    findAll()
 * @method Observation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Observation::class);
    }

    public function findById($id){
        $qb = $this->createQueryBuilder('o')
            ->andWhere('o.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        return $qb->getSingleResult();
    }


    /**
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countById($id){
        $qb = $this->createQueryBuilder('o')
            ->innerJoin('o.bird', 'b')
            ->where('b.id = :id')
            ->setParameter('id', $id);
        $qb->select($qb->expr()->count('o.bird'));

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countObservation($id) {
        $qb = $this->createQueryBuilder('o')
            ->select('o.bird, count(o)')
            ->where('o.status = 1')
            ->andWhere('o.bird = :id')
            ->setParameter('id', $id);
        $qb->select($qb->expr()->count('o.bird'));

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getNumberObservationsByUserId($id){
        $qb = $this->createQueryBuilder('o')
            ->where('o.observer = :id')
            ->setParameter('id', $id);
        $qb->select($qb->expr()->count('o.id'));

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findAllByUserId($id, $offset, $limit){
        return $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->where('o.observer = :id')
            ->setParameter('id', $id)
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult();
    }


    public function findObservationByBirdId($id){
       return $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.bird = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

    }

    public function findByObserver($observer, $offset, $limit){
        $qb = $this->createQueryBuilder('o')
            ->innerJoin('o.observer', 'observer')
            ->where('o.observer = :observer')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('observer', $observer)
            ->orderBy('o.addingDate', 'DESC')
            ->getQuery();

        return $qb->getResult();
    }

    public function findByValidator($validator, $offset, $limit){
        $qb = $this->createQueryBuilder('o')
            ->innerJoin('o.validator', 'v')
            ->where('o.validator = :validator')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('validator', $validator)
            ->orderBy('o.validationDate', 'DESC')
            ->getQuery();

        return $qb->getResult();
    }

    public function findWaitingObservation($offset, $limit){
        $qb = $this->createQueryBuilder('o')
            ->where('o.status = false')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('o.addingDate', 'DESC')
            ->getQuery();

        return $qb->getResult();
    }

    public function countWaintingObservation(){
        $qb = $this->createQueryBuilder('o')
            ->where('o.status = false');
        $qb->select($qb->expr()->count('o.id'));

        return $qb->getQuery()->getSingleScalarResult();
    }

//    /**
//     * @return Observation[] Returns an array of Observation objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Observation
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param $id
     * @return mixed
     */
    public function findByBirdId($id)
    {
        return $this->createQueryBuilder('o')
            ->where('o.bird = :id', 'o.status = 1')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }


    public function findObservationsByBirdId($id, $offset, $limit)
    {
        return $this->createQueryBuilder('o')
            ->setFirstResult( $offset )
            ->setMaxResults( $limit )
            ->where('o.bird = :id', 'o.status = 1')
            ->setParameter('id', $id)
            ->orderBy('o.observationDate', 'desc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return mixed
     * For functionality test
     */
    public function findAllValidateBirds()
    {
        return $this->createQueryBuilder('o')
            ->where('o.status = 1')
            ->orderBy('o.observationDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $offset
     * @param $limit
     * @return mixed
     */
    public function findLastThreeObservations($offset, $limit)
    {
        return $this->createQueryBuilder('o')
            ->select('o')
            ->setFirstResult( $offset )
            ->setMaxResults( $limit )
            ->where('o.status = 1')
            ->orderBy('o.observationDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

}
