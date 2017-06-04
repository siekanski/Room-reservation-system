<?php

namespace rrsystemBundle\Form\Type\Room;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
                ->add('name','text',array('label'=>'Name'))
                ->add('description','textarea',array('label'=>'Description'))
                ->add('size','integer', array('label'=>'Size'))
                ->add('Save', 'submit')
        ;
    }
    public function getName() {
        
    }
}

