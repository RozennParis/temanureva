<?php
/**
 * Created by PhpStorm.
 * User: rozenn
 * Date: 21/08/18
 * Time: 19:45
 */

namespace App\Controller;

use App\Entity\Bird;
use App\Entity\Observation;
use App\Form\BirdListType;
use App\Service\BreadcrumbManager;
use App\Service\PaginationManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BirdController extends Controller
{
    const NBR_BIRDS_PER_PAGE = 30;

    const PAGINATION_DISPLAY_BIRDS = 5;
    const PAGINATION_DISPLAY_MANAGE = 5;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/liste-photos-especes-oiseaux-france/{page}", name="oiseaux", requirements={"page"="\d+"})
     */
    public function showAllBirds($page = 1, Request $request)
    {

        //Insert breadcrumb
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('oiseaux', 'Espèces');


        $birdList = new Bird();

        $form = $this->createForm(BirdListType::class, $birdList);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $repository = $this->getDoctrine()->getRepository(Bird::class);
            $nbBirds = $repository->getNumberBirds();

            $sort = $form['sort']->getData();

            switch ($sort) {
                case ($sort === 0) :
                    $birds = $repository->findByVernacularName(($page - 1) * self::NBR_BIRDS_PER_PAGE, self::NBR_BIRDS_PER_PAGE);
                    $pagination = new PaginationManager($page, $nbBirds, self::NBR_BIRDS_PER_PAGE, self::PAGINATION_DISPLAY_BIRDS, 'oiseaux');
                    break;
                case ($sort === 1) :
                    $birds = $repository->findByDescVernacularName(($page - 1) * self::NBR_BIRDS_PER_PAGE, self::NBR_BIRDS_PER_PAGE);
                    $pagination = new PaginationManager($page, $nbBirds, self::NBR_BIRDS_PER_PAGE, self::PAGINATION_DISPLAY_BIRDS, 'oiseaux');
                    break;
                /*case ($sort = 2):
                    $brice = $repository->findByvernacularName(($page-1)*self::NBR_BIRDS_PER_PAGE,self::NBR_BIRDS_PER_PAGE);
                    break;
                case ($sort = 3) :
                    $birds = $repository->findByvernacularName(($page-1)*self::NBR_BIRDS_PER_PAGE,self::NBR_BIRDS_PER_PAGE);
                    break;*/

            }
            return $this->render('front/birds.html.twig', [
                'birds' => $birds,
                'pagination' => $pagination,
                'breadcrumb' => $breadcrumb->getBreadcrumb(),
                'form' => $form->createView()
            ]);


            //Insert pagination
            //$pagination = new PaginationManager($page, $nbBirds, self::NBR_BIRDS_PER_PAGE, self::PAGINATION_DISPLAY_BIRDS, 'oiseaux');


        }
        else {
            $repository = $this->getDoctrine()->getRepository(Bird::class);
            $birds = $repository->findByVernacularName(($page - 1) * self::NBR_BIRDS_PER_PAGE, self::NBR_BIRDS_PER_PAGE);
            $nbBirds = $repository->getNumberBirds();

            //Insert pagination
           $pagination = new PaginationManager($page, $nbBirds, self::NBR_BIRDS_PER_PAGE, self::PAGINATION_DISPLAY_BIRDS, 'oiseaux');
            return $this->render('front/birds.html.twig', [
                'birds' => $birds,
                'pagination' => $pagination,
                'breadcrumb' => $breadcrumb->getBreadcrumb(),
                'form' => $form->createView()
            ]);
        }
/*
        // Database request
        $repository = $this->getDoctrine()->getRepository(Bird::class);
        $birds = $repository->findByvernacularName(($page-1)*self::NBR_BIRDS_PER_PAGE,self::NBR_BIRDS_PER_PAGE);
        $nbBirds = $repository->getNumberBirds();

        //Insert pagination
        $pagination =  new PaginationManager($page, $nbBirds,self::NBR_BIRDS_PER_PAGE,self::PAGINATION_DISPLAY_BIRDS, 'oiseaux');

        //Insert breadcrumb
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('oiseaux', 'Espèces');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $sort = $form['sort']->getData();
            switch ($sort) {
                case ($sort = 1 ) :
                    $birds = $repository->findByDescVernacularName(($page-1)*self::NBR_BIRDS_PER_PAGE,self::NBR_BIRDS_PER_PAGE);
                    break;
                /*case ($sort = 2):
                    $brice = $repository->findByvernacularName(($page-1)*self::NBR_BIRDS_PER_PAGE,self::NBR_BIRDS_PER_PAGE);
                    break;
                case ($sort = 3) :
                    $birds = $repository->findByvernacularName(($page-1)*self::NBR_BIRDS_PER_PAGE,self::NBR_BIRDS_PER_PAGE);
                    break;
            }
            return $this->render('front/birds.html.twig', [
                'birds' => $birds,
                'pagination' => $pagination,
                'breadcrumb' => $breadcrumb->getBreadcrumb(),
                'form' => $form->createView()
            ]);
        }
        return $this->render('front/birds.html.twig', [
            'birds' => $birds,
            'pagination' => $pagination,
            'breadcrumb' => $breadcrumb->getBreadcrumb(),
            'form' => $form->createView()
        ]);*/
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/espece/{id}", name="oiseau")
     */
    public function birdAction($id){

        //Requete BDD
        $bird = $this->getDoctrine()
            ->getRepository(Bird::class)
            ->findBirdById($id);

        $observation = $this->getDoctrine()
            ->getRepository(Observation::class)
            ->findObservationByBirdId($id);

        return $this->render('front/specie.html.twig', [
            'bird' => $bird,
            'observation' => $observation,
        ]);
    }
}