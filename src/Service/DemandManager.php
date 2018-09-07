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
    private $mail;
    private $targetDirectory;

    public function __construct(EntityManagerInterface $entityManager, FileManager $fileManager, TokenStorageInterface $storage, MailManager $mail ,$directory)
    {
        $this->entityManager = $entityManager;
        $this->fileManager = $fileManager;
        $this->targetDirectory = $directory;
        $this->mail = $mail;
        $this->storage = $storage;
    }


    public function setDefaultDemand(Demand $demand){
        $demand
            ->setSubmitDate(new \DateTime())
            ->setUser($this->storage->getToken()->getUser());
        $this->entityManager->persist($demand);
        $this->entityManager->flush();
        $this->mail->sendDemandWaiting($demand);
    }

    public function certified(Demand $demand){
        if($demand->getUser()->getRoles() == ['ROLE_PARTICULAR']){
            $demand->getUser()->setRoles(['ROLE_NATURALIST']);
        }
        $this->mail->sendDemandAccept($demand);
    }

    public function decline(Demand $demand){
        $this->mail->sendDemandDecline($demand);
    }

    public function deleteDemand(Demand $demand){
        $this->deleteFile($demand);
        $this->entityManager->remove($demand);
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