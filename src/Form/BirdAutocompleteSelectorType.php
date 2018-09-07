<?php
/**
 * Created by PhpStorm.
 * User: rozenn
 * Date: 05/09/18
 * Time: 18:09
 */

namespace App\Form;

use App\Form\DataTransformer\BirdToStringTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BirdAutocompleteSelectorType extends AbstractType
{
    private $transformer;

    public function __construct(BirdToStringTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected bird does not exist',
        ));
    }

    public function getParent()
    {
        return HiddenType::class;
    }
}