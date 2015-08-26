<?php

namespace Barra\BackBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class IngredientType
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Form\Type
 */
class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'integer', [
                'required'  => false,
                'attr'      => [
                    'placeholder' => 'back.ingredient.amount',
                ],
            ])
            ->add('measurement', 'entity', [
                'class'     => 'BarraFrontBundle:Measurement',
                'property'  => 'name',
                'required'  => false,
                'attr'      => [
                    'placeholder' => 'back.measurement.name',
                ],
            ])
            ->add('product', 'entity', [
                'class'     => 'BarraFrontBundle:Product',
                'property'  => 'name',
                'attr'      => [
                    'placeholder' => 'back.product.name',
                ],
                'query_builder' => function(EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC')
                    ;
                },
            ])
            ->add('recipe', 'hidden', [
                'mapped'    => false,
                'label'     => false,
            ])
            ->add('submit', 'submit')
            ->getForm()
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'            => 'Barra\FrontBundle\Entity\Ingredient',
            'intention'             => 'ingredient',
            'csrf_protection'       => false,
            'cascade_validation'    => true,
            'validation_groups'     => [
                'ingredient',
            ],
        ]);
    }

    public function getName()
    {
        return 'formIngredient';
    }
}