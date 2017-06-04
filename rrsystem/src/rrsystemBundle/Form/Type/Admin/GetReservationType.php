<?php

namespace rrsystemBundle\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
                ->add('date', 'date', array('widget' => 'single_text'))
                ->add('submit', 'submit')
        ;
    }
    public function getName() {
        
    }
}

