<?php

namespace Barra\BackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('vegan', 'checkbox', array('required'=>false))
            ->add('kcal', 'number', array('precision'=>2))
            ->add('protein', 'number', array('precision'=>2))
            ->add('carbs', 'number', array('precision'=>2))
            ->add('sugar', 'number', array('precision'=>2))
            ->add('fat', 'number', array('precision'=>2))
            ->add('gfat', 'number', array('precision'=>2))
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
        return 'name';
    }
}