<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 29/08/18
 * Time: 17:10
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\ForgetPasswordType;
use App\Service\BreadcrumbManager;
use App\Service\ForgetPasswordManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ForgetPasswordController extends Controller
{
    /**
     * @Route("/mdp-oublie", name="forget-password")
     */
    public function indexAction(Request $request, ForgetPasswordManager $forgetPassword){
        //Breadcrumb
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('security_login', 'Connexion')
            ->add('forget-password', 'Mot de passe oublié');

        $user = new User();
        $form = $this->createForm(ForgetPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $forgetPassword->beginProcess($user);
            return $this->redirectToRoute('login');
        }

        return $this->render('front/forgetPassword.html.twig', [
            'breadcrumb' => $breadcrumb->getBreadcrumb(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/mdp-reinitalise/{token}", name="reinitialize-password")
     */
    public function reInitializedAction($token){

    }
}