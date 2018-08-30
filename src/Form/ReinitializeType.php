<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 30/08/18
 * Time: 01:55
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReinitializeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Votre adresse E-Mail'])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [ 'label' => 'Nouveau mot de passe'],
                'second_options' => [ 'label' => 'Confirmer nouveau mot de passe']
            ])
            ->add('submit', SubmitType::class, ['label' => 'Valider']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}