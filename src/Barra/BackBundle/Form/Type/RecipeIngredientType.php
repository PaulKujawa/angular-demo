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
            ->add('recipe', new RecipeType())
            ->add('ingredient', 'entity', array('class' => 'BarraFrontBundle:Ingredient', 'property' => 'name'))
            ->add('amount', 'integer')
            ->add('measurement', 'entity', array('class' => 'BarraFrontBundle:Measurement', 'property' => 'type'))

            ->add('clear', 'reset')
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Barra\FrontBundle\Entity\RecipeIngredient',
            'cascade_validation' => true,
            'validation_groups' => array('recipeIngredient')
        ));
    }

    public function getName()
    {
        return 'name';
    }
}