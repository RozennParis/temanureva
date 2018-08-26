<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 25/08/18
 * Time: 16:11
 */

namespace App\Controller;

use App\Entity\Demand;
use App\Form\DemandType;
use App\Service\BreadcrumbManager;
use App\Service\DemandManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DemandController extends Controller
{
    /**
     * @Route("/profil/demande", name="demand")
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
            return $this->redirectToRoute('profil');
        }

        return $this->render('demand/demand.html.twig', [
            'form' => $form->createView(),
            'breadcrumb' => $breadcrumb->getBreadcrumb()
        ]);
    }
}