<?php

namespace Barra\RecipeBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    /**
     * @{@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'attr'      => [
                    'placeholder' => 'recipe.product.name',
                ],
            ])
            ->add('vegan', 'checkbox', [
                'required' => false,
            ])
            ->add('gr', 'integer', [
                'attr'      => [
                    'placeholder' => 'recipe.product.gr',
                ],
            ])
            ->add('kcal', 'integer', [
                'attr'      => [
                    'placeholder' => 'recipe.product.kcal',
                ],
            ])
            ->add('protein', 'number', [
                'precision' => 2,
                'attr'      => [
                    'placeholder' => 'recipe.product.protein',
                ],
            ])
            ->add('carbs', 'number', [
                'precision' => 2,
                'attr'      => [
                    'placeholder' => 'recipe.product.carbs',
                ],
            ])
            ->add('sugar', 'number', [
                'precision' => 2,
                'attr'      => [
                    'placeholder' => 'recipe.product.sugar',
                ],
            ])
            ->add('fat', 'number', [
                'precision' => 2,
                'attr'      => [
                    'placeholder' => 'recipe.product.fat',
                ],
            ])
            ->add('gfat', 'number', [
                'precision' => 2,
                'attr'      => [
                    'placeholder' => 'recipe.product.gfat',
                ],
            ])
            ->add('manufacturer', 'entity', [
                'class'     => 'BarraRecipeBundle:Manufacturer',
                'property'  => 'name',
                'attr'      => [
                    'placeholder' => 'recipe.manufacturer.name',
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('m')
                        ->orderBy('m.name', 'ASC');
                },
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
            'data_class'        => 'Barra\RecipeBundle\Entity\Product',
            'csrf_protection'   => false,
        ]);
    }

    public function getName()
    {
        return 'formProduct';
    }
}
