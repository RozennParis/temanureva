<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 08/08/18
 * Time: 22:33
 */

namespace App\Service;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ArticleManager
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

    /**
     * @return Article
     */
    public function getDefaultArticle(){
        $article = new Article();
        $article
            ->setTitle('Votre Titre')
            ->setContent('Votre article')
            ->setStatus(false)
            ->setImage(null)
            ->setModificationDate(new \DateTime())
            ->setPublishingDate(null)
            ->setUser($this->storage->getToken()->getUser());

        return $article;
    }

    public function deleteArticle(Article $article){
        if($article->getImage() !== null){
            $this->deleteImage($article);
        }
        $this->entityManager->remove($article);
        $this->entityManager->flush();
    }

    public  function saveArticle(Article $article){
        $article->setModificationDate(new \DateTime());
        $this->entityManager->flush();
    }

    public  function publishArticle(Article $article){
        $article
            ->setPublishingDate(new \DateTime())
            ->setModificationDate(new \DateTime())
            ->setStatus(true);
        $this->entityManager->flush();
    }

    public function uploadImage(Article $article, UploadedFile $file){
        $fileName = $this->fileManager->upload($file, $this->imageDirectory);
        $article->setImage($fileName);
    }

    public function deleteImage(Article $article){
        $this->fileManager->delete($this->imageDirectory.'/'.$article->getImage());
        $article->setImage(null);
        $this->entityManager->flush();
    }
}