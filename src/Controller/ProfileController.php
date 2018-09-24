<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 30/08/18
 * Time: 22:47
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\modifyProfileType;
use App\Service\ProfileManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends Controller
{
    /**
     * @Route("/profil/modifier", name="modify-profile")
     */
    public function modifyAction(Request $request, UserPasswordEncoderInterface $encoder, ProfileManager $profileManager){

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findById($this->getUser()->getId());
        $form =  $this->createForm(modifyProfileType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
//            $result = $this->getDoctrine()->getRepository(User::class)->findByIdWithPassword($user->getId(), $encoder->encodePassword($user, $user->getPassword()));

//            if ($result !== null){
                if ($user->getNewImage() !== null){
                    $profileManager->uploadAndSetImage($user, $form->get('newImage')->getData());
                }
                if ($user->getNewPassword() !== null){
                    $profileManager->resetPassword($user);
                }
                $profileManager->modify($user);
                $this->addFlash('success', 'validate');
                return $this->redirectToRoute('profil');
//            }
        }

        return $this->render('back/modify_profile.html.twig',[
            'user' =>$user,
            'form' => $form->createView()
        ]);
    }
}