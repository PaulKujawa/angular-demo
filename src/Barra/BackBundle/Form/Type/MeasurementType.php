<?php

namespace Barra\BackBundle\Form\Type;

use Barra\FrontBundle\Entity\RecipeIngredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'text', array('attr'=>array('placeholder'=>'fb1')))
            ->add('gr', 'integer', array('attr'=>array('placeholder'=>'fb2')))
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