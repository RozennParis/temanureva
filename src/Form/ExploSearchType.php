<?php

namespace App\Form;

use App\Entity\Bird;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExploSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bird', TextType::class, ['label' =>'Nom de l\'espèce'] )
            ->add('location', TextType::class, ['label' => ' Localisation'])
            ->add('observation_date', DateType::class, [
                'label' => 'Date d\'observation',
                'attr' => ['class' => 'datepicker'],
                'widget' => 'single_text',
                'format'=> 'dd-MM-yyyy',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bird::class,
        ]);
    }
}
