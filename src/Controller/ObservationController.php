<?php

namespace App\Controller;

use App\Entity\Observation;
use App\Entity\Bird;
use App\Form\ObservationType;
use App\Service\BreadcrumbManager;
use App\Service\ObservationManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;



class ObservationController extends Controller
{
    /**
     * @Route("/ajout-observation", name="ajout_observation")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addObservation(Request $request, EntityManagerInterface $em, ObservationManager $observationManager)
    {
        $observation = new Observation();
        $form = $this->createForm(ObservationType::class, $observation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            /**
             * to get and set the observer user
             */
            $currentObserver = $this->getUser();
            $observation->setObserver($currentObserver);

            /**
             * to store image in db
             */
            if (null !== $observation->getImage() && $form->has('image')) {
                $observationManager->observationUpLoadImage($observation, $form->get('image')->getData());
            }

            $em->persist($observation);
            $em->flush();

            return $this->redirectToRoute('mes_observations');
        }

        //Insert breadcrumb
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('profil', 'Espèces');

        return $this->render('back/add_observation.html.twig', [
            'form' => $form->createView(),
            'breadcrumb' => $breadcrumb->getBreadcrumb()
        ]);
    }

    /**
     * @Route("/mes-observations", name="mes_observations")
     */
    public function showMyObservations()
    {
        return $this->render('back/my_observations.html.twig');
    }
}
