<?php

namespace App\Form;

use App\Entity\Observation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bird', TextType::class, [
                'label'=>'Nom de l\'espèce',
                //auocomplete TODO
            ])
            ->add('observation_date', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'observation',
                'format' => 'dd/MM/yyyy H:i',
                //'html5' => false,
                'attr' => [
                    'class' => 'datepicker'
                ],
                'required' => true

            ])
            ->add('location', TextType::class, [
                'Label' => 'Lieu d\'observation',
                'required' => true,
                // implementation of OpenStreetMap TODO
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de l\'observation',
                'attr' => [
                    'class' => 'file-field input-field'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Observation::class,
        ]);
    }
}
