<?php

namespace Barra\BackBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'integer', array(
                    'required' => false,
                    'attr'=>array('placeholder'=>'back.recipeIngredient.amount')
            ))
            ->add('measurement', 'entity', array(
                    'class' => 'BarraFrontBundle:Measurement',
                    'property' => 'type',
                    'required' => false,
                    'attr'=>array('placeholder'=>'back.measurement.type')
            ))
            ->add('ingredient', 'entity', array(
                    'class' => 'BarraFrontBundle:Ingredient',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('i')->orderBy('i.name', 'ASC');
                        },
                    'property' => 'name',
                    'attr'=>array('placeholder'=>'back.ingredient.name')
            ))
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
        return 'formRecipeIngredient';
    }
}