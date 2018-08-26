<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 26/08/18
 * Time: 16:16
 */

namespace App\Service;


use App\Entity\Demand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DemandManager
{
    private $entityManager;
    private $fileManager;
    private $storage;
    private $targetDirectory;

    public function __construct(EntityManagerInterface $entityManager, FileManager $fileManager, TokenStorageInterface $storage ,$directory)
    {
        $this->entityManager = $entityManager;
        $this->fileManager = $fileManager;
        $this->targetDirectory = $directory;
        $this->storage = $storage;
    }

    public function setDefaultDemand(Demand $demand){
        $demand
            ->setStatus(0)
            ->setUser($this->storage->getToken()->getUser());
        $this->entityManager->persist($demand);
        $this->entityManager->flush();
    }

    public function uploadFile(Demand $demand, UploadedFile $file){
        $fileName = $this->fileManager->upload($file, $this->targetDirectory);
        $demand->setCertificate($fileName);
    }

    public function deleteFile(Demand $demand){
        $this->fileManager->delete($this->targetDirectory.'/'.$demand->getCertificate());
    }
}