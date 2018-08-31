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
            ->add('bird', TextType::class, [
                'label' =>'Nom de l\'espèce',
                'attr' => [ 'class' => 'bird_research']
                ] )
            ->add('location', TextType::class, ['label' => ' Localisation'])
            ->add('observation_date_start', DateType::class, [
                'label' => 'Date d\'observation de début',
                'attr' => ['class' => 'datepicker'],
                'widget' => 'single_text',
                'format'=> 'dd/MM/yyyy',
                ])
            ->add('observation_date_end', DateType::class, [
                'label' => 'Date d\'observation de fin',
                'attr' => ['class' => 'datepicker'],
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
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
