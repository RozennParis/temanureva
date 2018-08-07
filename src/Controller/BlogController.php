<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 06/08/18
 * Time: 22:17
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/blog/{page}", name="blog", requirements={"page"="\d+"})
     */
    public function blogAction($page = 1){
        return $this->render('blog/index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/blog/article/{id}", name="blog-article", requirements={"id"="\d+"})
     */
    public function articleAction($id){
        return $this->render('blog/article.html.twig');
    }
}