<?php

namespace App\Controller;

use App\Form\ExploSearchType;
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
     * @Route("/profil", name="profil")
     */
    public function connectedInterface()
    {
        return $this->render('back/index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/exploration", name="exploration")
     */
    public function exploration()
    {
        $form = $this->createForm(ExploSearchType::class);

        return $this->render('front/exploration.html.twig', ['form' => $form->createView()]);
    }


}
