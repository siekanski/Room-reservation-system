<?php

namespace rrsystemBundle\Form\Type\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $hours = [
            '06'=>'06',
            '07'=>'07',
            '08'=>'08',
            '09'=>'09',
            '10'=>'10',
            '11'=>'11',
            '12'=>'12',
            '13'=>'13',
            '14'=>'14',
            '15'=>'15',
            '16'=>'16',
            '17'=>'17',
            '18'=>'18',
            '19'=>'19',
            '20'=>'20',
            '21'=>'21',
            '22'=>'22'
        ];
        $builder
                ->add('data', 'text', array('label'=>"Data:",'attr' => ['class' => 'date-picker']))
                ->add('timeStart', 'time', array('label'=>"Start:", 'widget' => 'choice',
                      'hours'=>$hours,
                      'minutes'=>['00'=>'00','30'=>'30']))
                ->add('timeEnd', 'time', array('label'=>"End:", 'widget' => 'choice',
                      'hours'=>$hours,
                      'minutes'=>['00'=>'00','30'=>'30']))
                ->add('Show', 'submit', array('attr' => array('class'=>'btn btn-primary',)))
        ;
    }
    public function getName() {
        
    }
}

