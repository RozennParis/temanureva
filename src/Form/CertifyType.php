<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 27/08/18
 * Time: 00:43
 */

namespace App\Form;

use App\Entity\Demand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertifyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('accept', SubmitType::class, ['label' => 'Valider la demande'])
            ->add('decline', SubmitType::class, ['label' => 'Refuse la demander']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demand::class,
        ]);
    }
}