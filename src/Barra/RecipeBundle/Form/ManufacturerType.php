<?php

namespace Barra\RecipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ManufacturerType
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Form
 */
class ManufacturerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'attr' => [
                    'placeholder' => 'recipe.manufacturer.name',
                ],
            ])
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'Barra\RecipeBundle\Entity\Manufacturer',
            'intention'         => 'manufacturer',
            'csrf_protection'   => false,
        ]);
    }

    public function getName()
    {
        return 'formManufacturer';
    }
}
