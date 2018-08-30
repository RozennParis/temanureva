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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
    /**
     * @Route("/profil/modifier", name="modify-profile")
     */
    public function modifyAction(){

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findById($this->getUser()->getId())
;        $form =  $this->createForm(modifyProfileType::class, $user);

        return $this->render('back/modify_profile.html.twig',[
            'form' => $form->createView()
        ]);
    }
}