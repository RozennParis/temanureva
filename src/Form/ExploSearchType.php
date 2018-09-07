<?php

namespace App\Form;

use App\Entity\Bird;
use App\Entity\Observation;
use App\Form\DataTransformer\BirdToStringTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExploSearchType extends AbstractType
{
    private $transformer;

    public function __construct(BirdToStringTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bird', HiddenType::class, [
                'label' =>'Nom de l\'espèce',
                'required' => false,
                'attr' => [ 'class' => 'bird_research']
                ] )
            /*->add('address', TextType::class, [
                'label' => ' Localisation',
                'required' => false,
                ])*/
            /*->add('observationDate', DateType::class, [
                'label' => 'Date de début',
                'required' => false,
                'attr' => ['class' => 'datepicker'],
                'widget' => 'single_text',
                'format'=> 'dd/MM/yyyy',
                ])*/

        ;
        $builder ->get('bird')
            ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Observation::class,
        ]);
    }
}
