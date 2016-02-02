<?php

namespace Barra\RecipeBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IngredientType extends AbstractType
{
    /**
     * @{@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'integer', [
                'required'  => false,
                'attr'      => [
                    'placeholder' => 'recipe.ingredient.amount',
                ],
            ])
//            TODO add query builder to sort measurements when i can check the result
            ->add('measurement', 'entity', [
                'class'     => 'BarraRecipeBundle:Measurement',
                'property'  => 'name',
                'required'  => false,
                'attr'      => [
                    'placeholder' => 'recipe.measurement.name',
                ],
            ])
            ->add('product', 'entity', [
                'class'     => 'BarraRecipeBundle:Product',
                'property'  => 'name',
                'attr'      => [
                    'placeholder' => 'recipe.product.name',
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
                },
            ])
            ->add('recipe', 'hidden', [
                'mapped'    => false,
                'label'     => false,
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
            'data_class'            => 'Barra\RecipeBundle\Entity\Ingredient',
            'csrf_protection'       => false,
        ]);
    }

    public function getName()
    {
        return 'formIngredient';
    }
}
