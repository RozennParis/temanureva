<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 06/08/18
 * Time: 22:17
 */

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profil/{id}/gerer-articles/{page}", name="gerer-articles", requirements={"id"="\d+", "page"="\d+"})
     */
    public function manageBlogAction($id, $page = 1){
        return $this->render('blog/manageBlog.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/pro/{id}/article/{id_article}", name="edit-article", requirements={"id"="\d+", "id_article"="\d+"})
     */
    public function editArticleAction(Request $request, $id, $id_article){

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        return $this->render('blog/editArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }
}