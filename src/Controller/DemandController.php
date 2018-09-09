<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 25/08/18
 * Time: 16:11
 */

namespace App\Controller;

use App\Entity\Demand;
use App\Form\CertifyType;
use App\Form\DemandType;
use App\Service\BreadcrumbManager;
use App\Service\DemandManager;
use App\Service\PaginationManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DemandController extends Controller
{
    const NBR_ARTICLE_DEMAND = 3;

    const PAGINATION_DISPLAY_DEMAND = 5;

    /**
     * @Route("/profil/demande", name="demand")
     * @param Request $request
     * @param DemandManager $demandManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function demandAction(Request $request, DemandManager $demandManager){
        //Breadcrumb
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('profil', 'Mon profil')
            ->add('demand', 'Demande naturaliste');

        $demand = new Demand();
        $form = $this->createForm(DemandType::class, $demand);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demandManager->uploadFile($demand, $form->get('certificate')->getData());
            $demandManager->setDefaultDemand($demand);
            $this->addFlash('success', 'Demande envoyé');
//            return $this->redirectToRoute('profil');
        }

        $alreadySubmit= $this->getDoctrine()
            ->getRepository(Demand::class)
            ->countByID($this->getUser()->getId());

        if($alreadySubmit > 0){
            return $this->render('demand/alreadySubmit.html.twig', [
                'breadcrumb' => $breadcrumb->getBreadcrumb()
            ]);
        }

        return $this->render('demand/demand.html.twig', [
            'form' => $form->createView(),
            'breadcrumb' => $breadcrumb->getBreadcrumb()
        ]);
    }

    /**
     * @Route("/profil/naturalistes-attente/{page}", name="waiting-demand", requirements={"page"="\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function waitingDemandAction($page = 1){
        //Breadcrumb
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('profil', 'Mon profil')
            ->add('waiting-demand', 'Demande naturaliste');

        $demands = $this->getDoctrine()
            ->getRepository(Demand::class)
            ->findWithOffset(($page-1)*self::NBR_ARTICLE_DEMAND,self::NBR_ARTICLE_DEMAND);

        $nbreDemand = $this->getDoctrine()
            ->getRepository(Demand::class)
            ->getNumberDemand();

        $pagination = new PaginationManager($page,$nbreDemand,self::NBR_ARTICLE_DEMAND,self::PAGINATION_DISPLAY_DEMAND, 'waiting-demand');

        return $this->render('demand/waitingDemand.html.twig', [
            'breadcrumb' => $breadcrumb->getBreadcrumb(),
            'demands' => $demands,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/profil/certification/{id}", name="certify-demand", requirements={"id"="\d+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cetifyDemandAction($id, Request $request, DemandManager $demandManager){

        $demand = $this->getDoctrine()
            ->getRepository(Demand::class)
            ->findById($id);

        $form = $this->createForm(CertifyType::class, $demand);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if ($form->getClickedButton()->getName() == 'accept'){
                $demandManager->certified($demand);
            }
            elseif ($form->getClickedButton()->getName() == 'decline'){
                $demandManager->decline($demand);
            }
            $demandManager->deleteDemand($demand);
            return $this->redirectToRoute('waiting-demand');
        }

        return $this->render('demand/certifyDemand.html.twig', [
            'form' => $form->createView(),
            'demand' => $demand
        ]);
    }
}