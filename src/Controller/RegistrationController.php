<?php
/**
 * Created by PhpStorm.
 * User: jesda
 * Date: 03/08/18
 * Time: 17:38
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Service\BreadcrumbManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/inscription", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $user->setRoles(['ROLE_PARTICULAR']);
            $user->setRegistrationDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('profil');
        }

        $breadcrumb = new BreadcrumbManager();
        $breadcrumb
            ->add('user_registration', 'Inscription');

        return $this->render('front/register.html.twig', [
            'form' => $form->createView(),
            'breadcrumb' => $breadcrumb->getBreadcrumb()
        ]);

    }

}