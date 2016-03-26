<?php

namespace Barra\RecipeBundle\Form;

use Barra\RecipeBundle\Entity\Ingredient;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'recipe.ingredient.amount',
                ],
            ])
//            TODO add query builder to sort measurements when i can check the result
            ->add('measurement', EntityType::class, [
                'class' => 'BarraRecipeBundle:Measurement',
                'property' => 'name',
                'required' => false,
                'attr' => [
                    'placeholder' => 'recipe.measurement.name',
                ],
            ])
            ->add('product', EntityType::class, [
                'class' => 'BarraRecipeBundle:Product',
                'property' => 'name',
                'attr' => [
                    'placeholder' => 'recipe.product.name',
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
                },
            ])
            ->add('recipe', HiddenType::class, [
                'mapped' => false,
                'label' => false,
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
            'data_class' => Ingredient::class,
            'csrf_protection' => false,
        ]);
    }
}
