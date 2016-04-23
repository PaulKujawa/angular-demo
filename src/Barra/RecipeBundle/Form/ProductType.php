<?php

namespace Barra\RecipeBundle\Form;

use Barra\RecipeBundle\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'recipe.product.name',
                ],
            ])
            ->add('vegan', CheckboxType::class, [
                'required' => false,
            ])
            ->add('gr', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'recipe.product.gr',
                ],
            ])
            ->add('kcal', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'recipe.product.kcal',
                ],
            ])
            ->add('protein', NumberType::class, [
                'label' => false,
                'scale' => 2,
                'attr' => [
                    'placeholder' => 'recipe.product.protein',
                ],
            ])
            ->add('carbs', NumberType::class, [
                'label' => false,
                'scale' => 2,
                'attr' => [
                    'placeholder' => 'recipe.product.carbs',
                ],
            ])
            ->add('sugar', NumberType::class, [
                'label' => false,
                'scale' => 2,
                'attr' => [
                    'placeholder' => 'recipe.product.sugar',
                ],
            ])
            ->add('fat', NumberType::class, [
                'label' => false,
                'scale' => 2,
                'attr' => [
                    'placeholder' => 'recipe.product.fat',
                ],
            ])
            ->add('gfat', NumberType::class, [
                'label' => false,
                'scale' => 2,
                'attr' => [
                    'placeholder' => 'recipe.product.gfat',
                ],
            ])
            ->add('manufacturer', EntityType::class, [
                'label' => false,
                'class' => 'BarraRecipeBundle:Manufacturer',
                'choice_label' => 'name',
                'attr' => [
                    'placeholder' => 'recipe.manufacturer.name',
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')->orderBy('m.name', 'ASC');
                },
            ])
            ->add('submit', SubmitType::class)
            ->getForm();
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'csrf_protection' => false,
        ]);
    }
}
