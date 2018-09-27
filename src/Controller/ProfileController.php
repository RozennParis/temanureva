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
use App\Service\BreadcrumbManager;
use App\Service\ProfileManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends Controller
{
    const NBR_USER_MANAGE = 8;
    const PAGINATION_DISPLAY_MANAGE = 5;

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

    /**
     * @Route("/profil/gerer-utilisateur/{page}", name="manage-user", requirements={"page"="\d+$"})
     */
    public function manageUser($page =1){
        //Insert breadcrumb
        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('profil', 'Mon profil')
            ->add('manage-user', 'Gérer utilisateur');

        $users = $this->getDoctrine()->getRepository(User::class)->findWithOffset(($page-1)*self::NBR_USER_MANAGE,self::NBR_USER_MANAGE);
        return $this->render('back/manage_user.html.twig', [
            'breadcrumb' => $breadcrumb->getBreadcrumb(),
            'users' => $users,
        ]);
    }
}