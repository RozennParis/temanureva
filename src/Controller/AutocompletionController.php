<?php

namespace App\Controller;

use App\Entity\Bird;
use App\Repository\BirdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class AutocompletionController extends Controller
{
    /**
     * @Route("/ajout-observation/autocomplete", name="autocomplete", methods={"GET", "POST"})
     */
    public function autocomplete(Request $request)
    {
        //$term = $_GET/POST ['unTruc];
       $term = $request->request->get('motcle');
       $em = $this->getDoctrine()->getManager();
       $birdsArray = $em->getRepository(Bird::class)->findAllByVernacularName($term);

       //$responseBird = new JsonResponse($birdsArray);
       return $responseBird = new JsonResponse($birdsArray);

       /*return $this->render('autocompletion/index.html.twig', [
            'responseBird' => $responseBird,
            'term' => $term,
            'birdsArray' => $birdsArray,
        ]);*/
    }
}
