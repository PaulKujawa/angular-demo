<?php

namespace Barra\BackBundle\Form\Type;

use Barra\FrontBundle\Entity\RecipeIngredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CookingStepUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipe', 'hidden', array('mapped' => false, 'label'=>false))
            ->add('step', 'integer', array('attr'=>array('placeholder'=>'back.cookingStep.step')))
            ->add('description', 'text', array('attr'=>array('placeholder'=>'back.cookingStep.description')))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Barra\FrontBundle\Entity\CookingStep',
            'intention' =>'cooking_step'
        ));
    }

    public function getName()
    {
        return 'formCookingStepUpdate';
    }
}