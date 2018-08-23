<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @param AuthenticationUtils $helper
     * @return Response
     * @Route("/connexion", name="security_login")
     */
    public function index(AuthenticationUtils $helper): Response
    {
        $error = $helper->getLastAuthenticationError();
        $lastUsername = $helper->getLastUsername();
        $form = $this->createForm(LoginType::class);

        return $this->render('security/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws \Exception
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(): void
    {
        throw new \Exception('Never be reached');
    }

}
