<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 09/09/18
 * Time: 14:21
 */

namespace App\Controller;


use App\Entity\Newsletter;
use App\Service\MailManager;
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
    public function subscribing(Request $request, NewsletterForm $newsletterForm, EntityManagerInterface $entityManager, MailManager $mail){
        $form = $newsletterForm->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newsletter = new Newsletter();
            $newsletter->setEmail($request->request->get('newsletter')['email']);
            $newsletter->setToken($request->request->get('newsletter')['_token']);
            $entityManager->persist($newsletter);
            $entityManager->flush();
            $mail->sendNewsletterValidation($newsletter);
            return $this->render('newsletter/subscribing.html.twig');
        }
        else{
            throw $this->createNotFoundException();
        }
    }

    /**
     * @Route("/newletters-confirmation", name="subscribe-confirmation")
     * @Method({"GET"})
     */
    public function confirmation(Request $request, EntityManagerInterface $entityManager){
        $email = $request->query->get('email');
        $token = $request->query->get('token');
        $newsletter =  $entityManager
            ->getRepository(Newsletter::class)
            ->findByEmail($email);
        if ( $newsletter !== null && $newsletter->getToken() === $token){
            $newsletter
                ->setToken(null)
                ->setSubscribingDate(new \DateTime());
            $this->addFlash('success', 'Votre abonnement à la newsletter confirmé');
            $entityManager->flush();
        }else{
            $this->addFlash('decline', "Erreur dans le processus d'abonnement");
        }
        return $this->redirectToRoute('security_login');
    }

    /**
     * @Route("/desabonement-newletters", name="unsubscribing")
     */
    public function unsubscribing(){

    }
}