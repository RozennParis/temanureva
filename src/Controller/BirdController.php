<?php
/**
 * Created by PhpStorm.
 * User: rozenn
 * Date: 21/08/18
 * Time: 19:45
 */

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BirdController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/oiseaux", name="oiseaux")
     */
    public function species()
    {
        return $this->render('front/birds.html.twig');
    }
}