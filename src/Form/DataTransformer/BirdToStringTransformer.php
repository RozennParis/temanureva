<?php
/**
 * Created by PhpStorm.
 * User: rozenn
 * Date: 27/08/18
 * Time: 15:43
 */

namespace App\Form\DataTransformer;

use App\Entity\Bird;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;



class BirdToStringTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (Bird) to a string (id)
     * @param mixed $bird
     * @return mixed|string
     */
    public function transform($bird)
    {
        if (null === $bird) {
            return '';
        }
        return $bird->getId();
    }

    public function reverseTransform($birdId){
        if (!$birdId){
            return;
        }

        $bird = $this->entityManager
            ->getRepository(Bird::class)
            ->find($birdId);

        if (null === $bird){
            throw new TransformationFailedException(sprintf(
                'Cet oiseau n\'est pas répertorié dans la base de données',
                $birdId
            ));
        }

        return $bird;
    }
}