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
            ->add('type', 'text')
            ->add('gr', 'integer')

            ->add('clear', 'reset')
            ->add('submit', 'submit')
            ->getForm();
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class'=>'Barra\FrontBundle\Entity\Measurement'));
    }

    public function getName()
    {
        return 'type';
    }
}