<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 06/08/18
 * Time: 22:17
 */



namespace App\Controller;

use App\Entity\Article;
use App\Form\AddArticleType;
use App\Form\ArticleType;
use App\Service\ArticleManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    const NBR_ARTICLE_BLOG = 6;
    const NBR_ARTICLE_MANAGE = 6;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/blog/{page}", name="blog", requirements={"page"="\d+"})
     */
    public function blogAction($page = 1){

        //Requete BDD
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findPublishedWithOffset(($page-1)*self::NBR_ARTICLE_BLOG,self::NBR_ARTICLE_BLOG);

        return $this->render('blog/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/blog/article/{id}", name="blog-article", requirements={"id"="\d+"})
     */
    public function articleAction($id){

        //Requete BDD
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findPublishedById($id);

        return $this->render('blog/article.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profil/{id}/gerer-articles/{page}", name="gerer-articles", requirements={"id"="\d+", "page"="\d+"})
     */
    public function manageBlogAction($id, $page = 1, ArticleManager $articleManager, Request $request){

        //Requete BDD
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findWithOffset(($page-1)*self::NBR_ARTICLE_MANAGE, self::NBR_ARTICLE_MANAGE);

        //Formulaire
        $article = new Article();
        $form = $this->createForm(AddArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($articleManager->getDefaultArticle());
            $entityManager->flush();

        }

        return $this->render('blog/manageBlog.html.twig', [
            'form' => $form->createView(),
            'articles' => $articles
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profil/{id}/article/{id_article}", name="edit-article", requirements={"id"="\d+", "id_article"="\d+"})
     */
    public function editArticleAction(Request $request, ArticleManager $articleManager, $id, $id_article){

        //Requete BDD
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findById($id_article);

        $form = $this->createForm(ArticleType::class, $article);

        //Si l'article n'est pas publié, on ajoute le bouton 'Publier'
        if($article->getStatus() === false){
            $form->add('publish', SubmitType::class, ['label' => 'Publier article']);
        }

        //Autre boutons ajoutés
        $form->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('delete', SubmitType::class, ['label' => 'Supprimer']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton()->getName() == 'delete'){
                $articleManager->deleteArticle($article);
            }
            elseif ($form->getClickedButton()->getName() == 'save'){
                $articleManager->saveArticle($article);
            }
            elseif ($form->getClickedButton()->getName() == 'publish'){
                $articleManager->publishArticle($article);
            }
            return $this->redirectToRoute('gerer-articles', ['id' => $id]);
        }

        return $this->render('blog/editArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }
}