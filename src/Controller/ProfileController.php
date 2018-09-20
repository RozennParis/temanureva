<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 30/08/18
 * Time: 22:47
 */

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Observation;
use App\Entity\User;
use App\Form\modifyProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{

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
        $observations = $this->getDoctrine()->getRepository(Observation::class)->findByObserver($user->getId(),0, 3);
        $validations = $this->getDoctrine()->getRepository(Observation::class)->findByValidator($user->getId(),0, 3);
        $articles = $this->getDoctrine()->getRepository(Article::class)->findByAuthor($user->getId(),0, 3);

        return $this->render('back/index.html.twig', [
            'user' => $user,
            'observations' => $observations,
            'validations' => $validations,
            'articles' => $articles
        ]);
    }


    /**
     * @Route("/profil/modifier", name="modify-profile")
     */
    public function modifyAction(){

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findById($this->getUser()->getId());
        $form =  $this->createForm(modifyProfileType::class, $user);

        return $this->render('back/modify_profile.html.twig',[
            'form' => $form->createView()
        ]);
    }
}