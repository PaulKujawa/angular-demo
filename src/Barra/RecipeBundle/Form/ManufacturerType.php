<?php

namespace Barra\RecipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ManufacturerType extends AbstractType
{
    /**
     * @{@inheritdoc}
     */
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

    /**
     * @{@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'Barra\RecipeBundle\Entity\Manufacturer',
            'csrf_protection'   => false,
        ]);
    }

    public function getName()
    {
        return 'formManufacturer';
    }
}
