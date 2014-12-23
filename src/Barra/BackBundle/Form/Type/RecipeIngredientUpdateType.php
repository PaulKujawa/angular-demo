<?php

namespace Barra\BackBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeIngredientUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipe', 'hidden', array(
                    'mapped' => false,
                    'label'=>false
                ))
            ->add('position', 'hidden', array(
                    'label'=>false
                ))
            ->add('amount', 'integer', array(
                    'required' => false,
                    'attr'=>array('placeholder'=>'back.recipeIngredient.amount')
                ))
            ->add('measurement', 'entity', array(
                    'class' => 'BarraFrontBundle:Measurement',
                    'property' => 'type',
                    'required' => false
                ))
            ->add('ingredient', 'entity', array(
                    'class' => 'BarraFrontBundle:Ingredient',
                    'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('i')->orderBy('i.name', 'ASC');
                        },
                    'property' => 'name'
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
        return 'formRecipeIngredientUpdate';
    }
}