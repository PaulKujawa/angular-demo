<?php

namespace Barra\BackBundle\Form\Type\Update;

use Barra\FrontBundle\Entity\RecipeIngredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MeasurementUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden', array(
                    'mapped' => false,
                    'label'=>false
                ))
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
        return 'formMeasurementUpdate';
    }
}