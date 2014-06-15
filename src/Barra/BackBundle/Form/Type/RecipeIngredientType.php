<?php

namespace Barra\BackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'integer')
    //        ->add('measurement', 'entity', array('class' => 'BarraFrontBundle:Measurement', 'property' => 'typ'))
      //      ->add('ingredient', 'entity', array('class' => 'BarraFrontBundle:Ingredient', 'property' => 'name'))

            ->add('clear', 'reset')
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class'=>'Barra\FrontBundle\Entity\RecipeIngredient'));
    }

    public function getName()
    {
        return 'name';
    }
}