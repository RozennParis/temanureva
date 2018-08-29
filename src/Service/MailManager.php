<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 28/08/18
 * Time: 19:37
 */

namespace App\Service;


use App\Entity\Demand;
use App\Entity\User;

class MailManager
{
    const MAIL_FROM = 'no-reply@example.fr';
    const MAIL_CONTACT = 'contact@exmaple.fr';

    private $mailer;
    private $template;
    private $contact;
    private $name;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $environment)
    {
        $this->mailer = $mailer;
        $this->template = $environment;
    }

    public function send($to, $subject, $body, $from = self::MAIL_FROM){
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setContentType('text/html')
            ->setBody($body);

        $this->mailer->send($message);
    }

    public function sendDemandWaiting(Demand $demand){
        $to = $demand->getUser()->getEmail();
        $subject = 'Votre demande pour devenir naturaliste';
        $body = $this->template->render('mail/demandeSubmit.html.twig', [
            'demand' => $demand
        ]);
        $this->send($to, $subject, $body);
    }

    public function sendDemandAccept(Demand $demand){
        $to = $demand->getUser()->getEmail();
        $subject = 'Votre demande a été accepter';
        $body = $this->template->render('mail/demandAccept.html.twig', [
            'demand' => $demand
        ]);
        $this->send($to, $subject, $body);
    }

    public function sendDemandDecline(Demand $demand){
        $to = $demand->getUser()->getEmail();
        $subject = 'Votre demande a été refusé';
        $body = $this->template->render('mail/demandDecline.html.twig', [
            'demand' => $demand
        ]);
        $this->send($to, $subject, $body);
    }
}