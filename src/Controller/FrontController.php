<?php

namespace App\Controller;

use App\Entity\Bird;
use App\Entity\Observation;
use App\Form\BirdListForm;
use App\Form\ExploSearchType;
use App\Service\BreadcrumbManager;
use PhpParser\Node\Expr\Array_;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('front/index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profil", name="profil")
     */
    public function connectedInterface()
    {
        return $this->render('back/index.html.twig');
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/observer-carte-oiseaux", name="exploration")
     */
    public function exploration(Request $request)
    {
        $form = $this->createForm(ExploSearchType::class);

        $form->handleRequest($request);

        /*if ($form->isSubmitted() && $form->isValid()) {

            $birdId = $form['bird']->getData();

            $result = [];

            if (!empty($birdId)) {
                $observations = $this->getDoctrine()
                    ->getRepository(Observation::class)
                    ->findByBirdId($birdId);
            } else {
                $observations = $this->getDoctrine()
                    ->getRepository(Observation::class)
                    ->findAllValidateBirds();
            }

            foreach ($observations as $observation) {
                $result[] = [
                    'id' => $observation->getId(),
                    'vernacularName' => $observation->getBird()->getVernacularName(),
                    'observationDate' => $observation->getObservationDate()->format('d/m/Y'),
                    'latitude' => $observation->getLatitude(),
                    'longitude' => $observation->getLongitude(),
                ];
            }
            return new JsonResponse($result);

        }*/


        $breadcrumb = new BreadcrumbManager();
        $breadcrumb->add('exploration', 'Exploration');

        return $this->render('front/exploration.html.twig', [
            'form' => $form->createView(),
            'breadcrumb' => $breadcrumb->getBreadcrumb()]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/observer-carte-oiseaux/rechercher", name="exploration_json_bird")
     */
    public function explorationSearchBirdAction(Request $request)
    {
        $birdId = (int) $request->request->get('explo_search_bird');
        $result = [];

        dump($birdId);
        if (!empty($birdId)) {
            $observations = $this->getDoctrine()
                ->getRepository(Observation::class)
                ->findByBirdId($birdId);
        } else {
            $observations = $this->getDoctrine()
                ->getRepository(Observation::class)
                ->findAllValidateBirds();
        }

        foreach ($observations as $observation) {
            $result[] = [
                'id' => $observation->getId(),
                'vernacularName' => $observation->getBird()->getVernacularName(),
                'observationDate' => $observation->getObservationDate()->format('d/m/Y'),
                'latitude' => $observation->getLatitude(),
                'longitude' => $observation->getLongitude(),
            ];
        }
        return new JsonResponse($result);
    }




}
