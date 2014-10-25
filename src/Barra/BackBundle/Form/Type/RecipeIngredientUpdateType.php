<?php

namespace Barra\BackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeIngredientUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ingredientId', 'hidden', array('mapped' => false, 'label'=>false))
            ->add('recipe', 'hidden', array('mapped' => false, 'label'=>false))
            ->add('position', 'hidden', array('label'=>false))
            ->add('amount', 'integer', array('attr'=>array('placeholder'=>'back.recipeIngredient.amount')))
            ->add('measurement', 'entity', array('class' => 'BarraFrontBundle:Measurement', 'property' => 'type', 'attr'=>array('placeholder'=>'back.measurement.type')))
            ->add('ingredient', 'entity', array('class' => 'BarraFrontBundle:Ingredient', 'property' => 'name', 'attr'=>array('placeholder'=>'back.ingredient.name')))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Barra\FrontBundle\Entity\RecipeIngredient',
            'cascade_validation' => true,
            'validation_groups' => array('recipeIngredient'),
            'intention' => 'recipeIngredient'
        ));
    }

    public function getName()
    {
        return 'formRecipeIngredientUpdate';
    }
}