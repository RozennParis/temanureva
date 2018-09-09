<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 09/09/18
 * Time: 14:21
 */

namespace App\Controller;


use App\Entity\Newsletter;
use App\Service\NewsletterForm;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends Controller
{
    /**
     * @Route("/abonement-newletters", name="subscribing")
     * @Method({"POST"})
     */
    public function subscribing(Request $request, NewsletterForm $newsletterForm, EntityManagerInterface $entityManager){
        $form = $newsletterForm->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newsletter = new Newsletter();
            $newsletter->setEmail($request->request->get('newsletter')['email']);
            $newsletter->setToken($request->request->get('newsletter')['_token']);
            $entityManager->persist($newsletter);
            $entityManager->flush();

            return $this->render('newsletter/subscribing.html.twig');
        }
        else{
            throw $this->createNotFoundException();
        }
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