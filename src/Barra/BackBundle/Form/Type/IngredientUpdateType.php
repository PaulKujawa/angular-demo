<?php

namespace Barra\BackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IngredientUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden', array('mapped' => false, 'label'=>false))
            ->add('name', 'text', array('attr'=>array('placeholder'=>'back.ingredient.name')))
            ->add('vegan', 'checkbox', array('required'=>false))
            ->add('gr', 'integer', array('attr'=>array('placeholder'=>'back.ingredient.gr')))
            ->add('kcal', 'number', array('precision'=>2, 'attr'=>array('placeholder'=>'back.ingredient.kcal')))
            ->add('protein', 'number', array('precision'=>2, 'attr'=>array('placeholder'=>'back.ingredient.protein')))
            ->add('carbs', 'number', array('precision'=>2, 'attr'=>array('placeholder'=>'back.ingredient.carbs')))
            ->add('sugar', 'number', array('precision'=>2, 'attr'=>array('placeholder'=>'back.ingredient.sugar')))
            ->add('fat', 'number', array('precision'=>2, 'attr'=>array('placeholder'=>'back.ingredient.fat')))
            ->add('gfat', 'number', array('precision'=>2, 'attr'=>array('placeholder'=>'back.ingredient.gfat')))
            ->add('manufacturer', 'entity', array('class' => 'BarraFrontBundle:Manufacturer', 'property' => 'name'))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Barra\FrontBundle\Entity\Ingredient',
            'intention' =>'ingredient'
        ));
    }

    public function getName()
    {
        return 'formIngredientUpdate';
    }
}