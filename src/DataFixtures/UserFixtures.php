<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$roles, $lastname, $firstname, $username, $email, $password, $registration_date]) {
            $user = new User();
            $user->setRoles([$roles]);
            $user->setLastname($lastname);
            $user->setFirstname($firstname);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setRegistrationDate($registration_date);

            $manager->persist($user);
            $this->addReference($username, $user);
        }
        $manager->flush();
    }

    public function getUserData(): array
    {
        return [
            ['ROLE_ADMIN', 'KAVERA', 'Augustin', 'Jesdax', 'admin@outlook.fr', 'hello', new \DateTime('NOW')],
        ];
    }
}
