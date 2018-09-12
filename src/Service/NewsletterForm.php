<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 09/09/18
 * Time: 17:30
 */

namespace App\Service;


use App\Form\NewsletterType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class NewsletterForm
{
    private $form;
    private $router;
    private $formFactory;

    public function __construct(UrlGeneratorInterface $router,FormFactoryInterface $formFactory)
    {
        $this->router = $router;
        $this->formFactory = $formFactory;

        $this->form = $this->formFactory->create(NewsletterType::class, null, [
            'attr' => [
                'action' => $this->router->generate('subscribing')
            ]
        ]);
    }

    public function getForm(){
        return $this->form;
    }

}