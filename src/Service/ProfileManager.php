<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 21/09/18
 * Time: 20:05
 */

namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileManager
{
    private $entityManager;
    private $fileManager;
    private $encoder;
    private $imageDirectory;

    public function __construct(EntityManagerInterface $entityManager, FileManager $fileManager, UserPasswordEncoderInterface $encoder, $directory)
    {
        $this->entityManager = $entityManager;
        $this->fileManager = $fileManager;
        $this->encoder = $encoder;
        $this->imageDirectory = $directory;
    }

    public function uploadAndSetImage(User $user, UploadedFile $file){
        if ($user->getImage() !== null){
            $this->deleteImage($user);
        }
        $fileName = $this->fileManager->upload($file, $this->imageDirectory);
        $user->setImage($fileName);
    }

    public function deleteImage(User $user){
        $this->fileManager->delete($this->imageDirectory.'/'.$user->getImage());
        $user->setImage(null);
    }

    public function resetPassword(User $user){
        $password = $this->encoder->encodePassword($user, $user->getNewPassword());
        $user->setPassword($password);
    }

    public function modify(User $user){
        $this->entityManager->flush();
    }
}