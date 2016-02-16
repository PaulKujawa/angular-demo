<?php

namespace Barra\RecipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MeasurementType extends AbstractType
{
    /**
     * @{@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'recipe.measurement.name',
                ],
            ])
            ->add('gr', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'recipe.measurement.gr',
                ],
            ])
            ->add('submit', SubmitType::class)
            ->getForm();
    }

    /**
     * @{@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'Barra\RecipeBundle\Entity\Measurement',
            'csrf_protection'   => false,
        ]);
    }

    public function getName()
    {
        return 'formMeasurement';
    }
}
