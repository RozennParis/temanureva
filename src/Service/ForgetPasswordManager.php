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

class ForgetPasswordManager
{
    private $mail;
    private $entityManager;

    public function __construct(MailManager $mail, EntityManagerInterface $entityManager)
    {
        $this->mail = $mail;
        $this->entityManager = $entityManager;
    }

    public function beginProcess(User $userTarget){
        $email = $userTarget->getEmail();
        $user = $this->entityManager->getRepository(User::class)->findByEmail($email);
        if ($user !== null){
            $this->setToken($user);
            $this->mail->sendReInitialize($user);
        }
    }

    public function setToken(User $user){
        $token = $this->generateToken();
        $user
            ->setToken($token)
            ->setTokenDate(new \DateTime());
        $this->entityManager->flush();
    }

    private function generateToken(){
        return bin2hex(random_bytes(8));
    }
}