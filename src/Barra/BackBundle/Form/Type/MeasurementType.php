<?php

namespace Barra\BackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'text', array(
                    'attr'=>array('placeholder'=>'back.measurement.type')
                ))
            ->add('gr', 'integer', array(
                    'attr'=>array('placeholder'=>'back.measurement.gr')
                ))
            ->add('submit', 'submit')
            ->getForm();
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class'=>'Barra\FrontBundle\Entity\Measurement',
            'intention' =>'measurement'));
    }

    public function getName()
    {
        return 'type';
    }
}