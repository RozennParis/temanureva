<?php
/**
 * Created by PhpStorm.
 * User: rozenn
 * Date: 22/08/18
 * Time: 16:05
 */

namespace App\Service;

use App\Entity\Bird;
use Doctrine\ORM\EntityManagerInterface;

class BirdsManager
{

    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}