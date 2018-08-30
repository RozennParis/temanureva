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
     * @Route("/autocomplete", name="autocomplete", methods={"GET", "POST"})
     */
    public function autocomplete(Request $request)
    {
       $term = $request->request->get('dataBird');
       $em = $this->getDoctrine()->getManager();
       $birdsArray = $em->getRepository(Bird::class)->findAllByVernacularName($term);

       $responseBird = new JsonResponse($birdsArray);

        //$responseBird->headers->set('Content-Type', 'application/json');

        return $responseBird;

    }
}
