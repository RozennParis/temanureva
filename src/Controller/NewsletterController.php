<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 09/09/18
 * Time: 14:21
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends Controller
{
    /**
     * @Route("/abonement-newletters", name="subscribing")
     * @Method({"POST"})
     */
    public function subscribing(Request $request){
        return $this->render('newsletter/subscribing.html.twig');
    }

    /**
     * @Route("/newletters-confirmation", name="subscribe-confirmation")
     */
    public function confirmation(){

    }

    /**
     * @Route("/desabonement-newletters", name="unsubscribing")
     */
    public function unsubscribing(){

    }
}