<?php

namespace App\Form;

use App\Form\DataTransformer\BirdToStringTransformer;
use App\Entity\Observation;
use App\Entity\Bird;
use Doctrine\ORM\EntityRepository;
use App\Repository\BirdRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationType extends AbstractType
{
    private $transformer;

    public function __construct(BirdToStringTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //test avec autocompletion JS et Ajax
           ->add('bird', HiddenType::class, [
                'label'=>'Nom de l\'espèce ',
                'required' => false,
                'attr' =>[
                    'class' => 'bird_research'
                ]
            ])

            //test avec EntityType
           /*->add('bird', EntityType::class, [
                'label'=>'Nom de l\'espèce ',
                'class' => Bird::class,
                'query_builder' => function (BirdRepository $br) {
                    return $br->createQueryBuilder('b')
                        ->orderBy('b.vernacularName', 'ASC');
                },
                'required'=> false,
            ])*/
            ->add('observation_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'observation *',
                'format' => 'dd-MM-yyyy',
                'html5' => true,
                'attr' => [
                    'class' => 'datepicker'
                ],
                'required' => true

            ])

            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
                // implementation of OpenStreetMap aaahTODO
            ])

            ->add('latitude', TextType::class, [
                'label' => 'Latitude',
                'required' => true,
                // implementation of OpenStreetMap aaahTODO
            ])
            ->add('longitude', TextType::class, [
                'label' => 'Longitude',
                'required' => true,
                // implementation of OpenStreetMap aaahTODO
            ])

            ->add('image', FileType::class, [
                'label' => 'Image de l\'observation',
                'attr' => [
                    'class' => 'file-field input-field'
                ],
                'required' => false
            ])

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
