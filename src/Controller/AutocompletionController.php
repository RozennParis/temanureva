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
    public function autocomplete(Request $request, EntityManagerInterface $em)
    {
       $term =$_POST['dataBird'];
       /*$em = $this->getDoctrine()->getManager();
       $birdsArray = $em->getRepository(Bird::class)->find($term);
       dump($birdsArray); die;
       return $responseBird = new JsonResponse($birdsArray);*/
        dump($term);
        //$term = $request->request->get('dataBird');
        $array = $em->getRepository(Bird::class)->findByVernacularName($term);

        $response = new Response(json_encode($array));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }
}

/**
 * @Route("/autocomp", name="autocomp")
 * @Method({"GET", "POST"})
 */
/*public function autocompAction(Request $request)
{

    $em = $this->getDoctrine()->getManager();

    $term = $request->request->get('motcle');

    $array = $em->getRepository('AppBundle:Oiseaux')->nomOiseau($term);

    $response = new Response(json_encode($array));

    $response->headers->set('Content-Type', 'apllication/json');

    return $response;

}*/