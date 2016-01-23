<?php

namespace Barra\RecipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MeasurementType
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Form
 */
class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'attr' => [
                    'placeholder' => 'recipe.measurement.name',
                ],
            ])
            ->add('gr', 'integer', [
                'attr' => [
                    'placeholder' => 'recipe.measurement.gr',
                ],
            ])
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'Barra\RecipeBundle\Entity\Measurement',
            'intention'         => 'measurement',
            'csrf_protection'   => false,
        ]);
    }

    public function getName()
    {
        return 'formMeasurement';
    }
}
