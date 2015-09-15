<?php

namespace Barra\BackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MeasurementType
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Form\Type
 */
class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'attr' => [
                    'placeholder' => 'back.measurement.name',
                ],
            ])
            ->add('gr', 'integer', [
                'attr' => [
                    'placeholder' => 'back.measurement.gr',
                ],
            ])
            ->add('submit', 'submit')
            ->getForm()
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'Barra\FrontBundle\Entity\Measurement',
            'intention'         => 'measurement',
            'csrf_protection'   => false,
        ]);
    }

    public function getName()
    {
        return 'formMeasurement';
    }
}
