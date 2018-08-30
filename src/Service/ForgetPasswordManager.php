<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 29/08/18
 * Time: 20:10
 */

namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ForgetPasswordManager
{
    private $mail;
    private $entityManager;
    private $encoder;

    public function __construct(MailManager $mail, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->mail = $mail;
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    /**
     * Debut du processus de réinitialisation
     * @param User $userTarget
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function beginProcess(User $userTarget){
        $email = $userTarget->getEmail();
        $user = $this->entityManager->getRepository(User::class)->findByEmail($email);
        if ($user !== null){
            $this->setToken($user);
            $this->mail->sendReinitializeProcess($user);    //Envoie email
        }
    }

    /**
     * Réinitialise le mot de passe d'un utilisateur
     * @param User $user
     * @param User $userTarget
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function reinitialize(User $user, User $userTarget){
        $password = $this->encoder->encodePassword($user, $userTarget->getPassword());
        $user
            ->setPassword($password)
            ->setToken(null)
            ->setTokenDate(null);
        $this->entityManager->flush();
        $this->mail->sendReinitializeNotification($user);   //Envoie email
    }

    /**
     * Verifie si la limite de temps du jeton est toujour valide
     * @param User $user
     * @return bool
     */
    public function isTimeOut(User $user){
        $tokenDate = $user->getTokenDate();
        if ($tokenDate === null){
            return true;
        }

        $interval = $tokenDate->diff(new \DateTime());
        $minute = (int)$interval->format('%i');
        if($minute <15){
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Insère le jeton et sa date de création
     * @param User $user
     */
    public function setToken(User $user){
        $token = $this->generateToken();
        $user
            ->setToken($token)
            ->setTokenDate(new \DateTime());
        $this->entityManager->flush();
    }

    /**
     * Génère un jeton aléatoire
     * @return string
     * @throws \Exception
     */
    private function generateToken(){
        return bin2hex(random_bytes(8));
    }
}