<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ContactType;
use App\Service\MailManager;
use App\Utility\Contact;
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
     * @Route("/profil/{id}", name="profil", requirements={"id"="\d+$"})
     */
    public function connectedInterface($id = -1)
    {
        //J'ai doullé de ouf
        if($id === -1){
            return $this->redirectToRoute('profil',['id' => $this->getUser()->getId()]);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findById($id);

        return $this->render('back/index.html.twig', ['user' => $user]);
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/observer-carte-oiseaux", name="explorer")
     */
    public function exploration(Request $request)
    {
        $form = $this->createForm(ExploSearchType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dump( $form->get('bird'));die();

            $birdId = $form->get('bird');

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

            dump($result);die();
            return new JsonResponse($result);
        }

        /*if ($form->isSubmitted() && $form->isValid()) {

            $birdId = $form->get('bird')->getData();

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
     * @param MailManager $mail
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @Route("/contact-association-amis-oiseaux", name="contact")
     */
    public function contact(Request $request, MailManager $mail)
    {
        //Breadcrumb
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('contact', 'Nous contacter');
        //Form
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $mail->sendContact($contact);
        }
        return $this->render('front/contact.html.twig',[
            'breadcrumb' => $breadcrumb->getBreadcrumb(),
            'form' => $form->createView()
        ]);

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

        //dump($birdId);
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


    /**
     * @Route("/presentation-association-protection-amis-oiseaux", name="presentation")
     */
    public function presentationAssociation(){
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('presentation', 'Notre association');

        return $this->render('front/presentation.html.twig',['breadcrumb' => $breadcrumb->getBreadcrumb()]);
    }

    /**
     * @Route("/don-association-reduction-impots-amis-oiseaux", name="donation")
     */
    public function donation() {
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb->add('donation', 'Faire un don');

        return $this->render('front/donation.html.twig', [
            'breadcrumb' => $breadcrumb->getBreadcrumb()
        ]);
    }

    /**
     * @Route("/mentions-legales", name="mentions")
     */
    public function legalMentions() {
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('mentions', 'Mentions légales');

        return $this->render('front/legalMentions.html.twig', [
            'breadcrumb' => $breadcrumb->getBreadcrumb()
        ]);
    }

    /**
     * @Route("/FAQ", name="faq")
     */
    public function faq() {
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('faq', 'FAQ');

        return $this->render('front/faq.html.twig', [
            'breadcrumb' => $breadcrumb->getBreadcrumb()
        ]);
    }
}
