<?php
/**
 * Created by PhpStorm.
 * User: rozenn
 * Date: 21/08/18
 * Time: 19:45
 */

namespace App\Controller;

use App\Entity\Bird;
use App\Service\PaginationManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BirdController extends Controller
{
    const NBR_BIRDS_PER_PAGE = 30;

    const PAGINATION_DISPLAY_BIRDS = 5;
    CONST PAGINATION_DISPLAY_MANAGE = 5;

    const SORTING_A_TO_Z = true;
    const SORTING_Z_TO_A = false;
    const SORTING_INCREASE_OBSERVATIONS = false;
    const SORTING_DECREASE_OBSERVATIONS = false;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/oiseaux", name="oiseaux")
     */
    public function species()
    {
        $repository = $this->getDoctrine()->getRepository(Bird::class);

        $birds = $repository->findByLbName();

        return $this->render('front/birds.html.twig');
    }

    /**
     * @param null $id
     * @return Response
     * @Route("/oiseaux/rechercher/{id}", name="bird_search_id", requirements={"id": "\d+"})
     */
    public function searchBirdIdAction($id = null)
    {
        $bird = $this->getDoctrine()->getRepository(Bird::class)->find($id);

        if ($bird) {
            $name = $bird->getVernacularName() . '(' . $bird->getLbName() . ')';
            return new Response($name);
        }
        return new Response('');
    }


}