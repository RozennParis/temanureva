<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 08/08/18
 * Time: 22:33
 */

namespace App\Service;


use App\Entity\Article;
use App\Entity\User;

class ArticleManager
{
    /**
     * @return Article
     */
    public function getDefaultArticle(){
        $article = new Article();
        $article
            ->setTitle('Votre Titre')
            ->setContent('Votre article')
            ->setStatus('false')
            ->setImage(null)
            ->setModificationDate(new \DateTime())
            ->setPublishingDate(null)
            ->setUser(null);

        return $article;
    }
}