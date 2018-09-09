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
use App\Form\ReinitializeType;
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
            $this->addFlash('success', 'Un email vous a été envoyé pour réinitailiser votre mot de passe');
        }

        return $this->render('front/forgetPassword.html.twig', [
            'breadcrumb' => $breadcrumb->getBreadcrumb(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/mdp-reinitalise/{token}", name="reinitialize-password")
     */
    public function reInitializedAction($token, Request $request, ForgetPasswordManager $forgetPassword){
        $userTarget = new User();
        $form = $this->createForm(ReinitializeType::class, $userTarget);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if ($form->isValid()){
                $user = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->findByEmailAndToken($userTarget->getEmail(),$token);

                //Si la conbinaison email/token est valide
                if($user !== null){
                    //Si le token est encore valide
                    if (!$forgetPassword->isTimeOut($user)){
                        $forgetPassword->reinitialize($user, $userTarget);
                        $this->addFlash('success', 'Votre mot de passe a été réinitialisé');
                        return $this->redirectToRoute('security_login');
                    }
                    else{
                        $this->addFlash('decline', 'Le temps limite dépassé');
                    }
                }
                else{
                    $this->addFlash('decline', 'Les informations sont incorrect');
                }
            }
            else{
                $this->addFlash('decline', 'Les informations sont incorrect');
            }
        }

        return $this->render('front/reinitialize.html.twig',[
            'form' => $form->createView()
        ]);
    }
}