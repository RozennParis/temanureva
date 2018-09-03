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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class BirdsManager
{

    private $entityManager;
    private $fileManager;
    private $storage;
    private $imageDirectory;

    public function __construct(EntityManagerInterface $entityManager, FileManager $fileManager, TokenStorageInterface $storage ,$directory)
    {
        $this->entityManager = $entityManager;
        $this->fileManager = $fileManager;
        $this->imageDirectory = $directory;
        $this->storage = $storage;
    }

}