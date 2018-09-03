<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 01/09/18
 * Time: 14:36
 */

namespace App\Form;

use App\Utility\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, ['label' => 'Prenom*'])
            ->add('lastname', TextType::class, ['label' => 'Nom*'])
            ->add('email', EmailType::class, ['label' => 'Adresse E-Mail*'])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'required' => false
            ])
            ->add('subject', TextType::class, ['label' => 'Sujet*'])
            ->add('message', TextareaType::class, ['label' => 'Message*']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}