<?php

namespace rrsystemBundle\Form\Type\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
                ->add('projector','choice', array('choices'=>['Yes'=>'Yes','No'=>'No'],'label'=>'Projector'))
                ->add('submit', 'submit', array('attr'=>array('class'=>'btn btn-primary'),'label'=>'Submit'))
        ;
    }
    public function getName() {
        
    }
}

