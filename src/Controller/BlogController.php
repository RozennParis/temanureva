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
use App\Form\ArticleWhitoutImageType;
use App\Service\ArticleManager;
use App\Service\BreadcrumbManager;
use App\Service\PaginationManager;
use function Sodium\add;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    const NBR_ARTICLE_BLOG = 6;
    const NBR_ARTICLE_MANAGE = 6;

    const PAGINATION_DISPLAY_BLOG = 5;
    const PAGINATION_DISPLAY_MANAGE = 5;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/amis-oiseaux-articles-blog-information/{page}", name="blog", requirements={"page"="\d+"})
     */
    public function blogAction($page = 1){

        //Requete BDD
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repository->findPublishedWithOffset(($page-1)*self::NBR_ARTICLE_BLOG,self::NBR_ARTICLE_BLOG);
        $nbreArticle = $repository->getNumberPublishedArticle();

        //Pagination
        $pagination =  new PaginationManager($page, $nbreArticle,self::NBR_ARTICLE_BLOG,self::PAGINATION_DISPLAY_BLOG, 'blog');

        //Breadcrumb
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('blog', 'Blog');

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
            'pagination' => $pagination,
            'breadcrumb' => $breadcrumb->getBreadcrumb()
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

        //Breadcrumb
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('blog', 'Blog')
            ->add('blog-article', 'Article', array('id' => $id));

        return $this->render('blog/article.html.twig', [
            'article' => $article,
            'breadcrumb' => $breadcrumb->getBreadcrumb()
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profil/gerer-articles/{page}", name="gerer-articles", requirements={"page"="\d+"})
     */
    public function manageBlogAction($page = 1, ArticleManager $articleManager, Request $request){

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
            return $this->redirectToRoute('gerer-articles');
        }

        $nbreArticle = $this->getDoctrine()
            ->getRepository(Article::class)
            ->getNumberArticle();

        //Pagination
        $pagination =  new PaginationManager($page,$nbreArticle,self::NBR_ARTICLE_BLOG,self::PAGINATION_DISPLAY_BLOG, 'gerer-articles');

        //Breadcrumb
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('profil', 'Mon profil')
            ->add('gerer-articles', 'Gérer les articles');

        return $this->render('blog/manageBlog.html.twig', [
            'form' => $form->createView(),
            'articles' => $articles,
            'pagination' => $pagination,
            'breadcrumb' => $breadcrumb->getBreadcrumb()
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profil/article/{id_article}", name="edit-article", requirements={"id_article"="\d+"})
     */
    public function editArticleAction(Request $request, ArticleManager $articleManager, $id_article){

        //Requete BDD
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findById($id_article);

        $form = '';

        if($article->getImage() === null){
            $form = $this->createForm(ArticleType::class, $article);
        }
        else{
            $form = $this->createForm(ArticleWhitoutImageType::class, $article);
        }

        //Si l'article n'est pas publié, on ajoute le bouton 'Publier'
        if($article->getStatus() === false){
            $form->add('publish', SubmitType::class, ['label' => 'Publier article']);
        }

        //Autre boutons ajoutés
        $form->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('delete', SubmitType::class, ['label' => 'Supprimer']);

        $form->handleRequest($request);

        //Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            //Supprimer image
            if ($form->getClickedButton()->getName() == 'delete_image'){
                $articleManager->deleteImage($article);
                return $this->redirectToRoute('edit-article', ['id_article' => $id_article]);
            }

            else{

                //Upload l'image
                if ($article->getImage() !==  null && $form->has('image')){
                    $articleManager->uploadImage($article, $form->get('image')->getData());
                }

                //Action en fonction du bouton
                if ($form->getClickedButton()->getName() == 'delete'){
                    $articleManager->deleteArticle($article);
                }
                elseif ($form->getClickedButton()->getName() == 'save'){
                    $articleManager->saveArticle($article);
                }
                elseif ($form->getClickedButton()->getName() == 'publish'){
                    $articleManager->publishArticle($article);
                }
                return $this->redirectToRoute('gerer-articles');
            }
        }

        //Breadcrumb
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('profil', 'Mon profil')
            ->add('gerer-articles', 'Article')
            ->add('edit-article', 'Editer article', array('id_article' => $id_article));

        return $this->render('blog/editArticle.html.twig', [
            'form' => $form->createView(),
            'breadcrumb' => $breadcrumb->getBreadcrumb()
        ]);
    }
}