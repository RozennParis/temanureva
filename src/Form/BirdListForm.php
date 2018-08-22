<?php
/**
 * Created by PhpStorm.
 * User: rozenn
 * Date: 22/08/18
 * Time: 15:33
 */

namespace App\Form;


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
class BirdListForm extends AbstractType
{
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
                 'choice_label' => 'vernacularName',
                 'required'=> false,
             ])*/

            ->add('location', TextType::class, [
                'label' => 'Lieu d\'observation *',
                'required' => true,
                // implementation of OpenStreetMap TODO
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de l\'observation',
                'attr' => [
                    'class' => 'file-field input-field'
                ],
                'required' => false
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