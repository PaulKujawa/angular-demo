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
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'integer', array(
                'required'  => false,
                'attr'      => array(
                    'placeholder' => 'back.ingredient.amount',
                ),
            ))
            ->add('measurement', 'entity', array(
                'class'     => 'BarraFrontBundle:Measurement',
                'property'  => 'type',
                'required'  => false,
                'attr'      => array(
                    'placeholder' => 'back.measurement.type',
                ),
            ))
            ->add('product', 'entity', array(
                'class'     => 'BarraFrontBundle:Product',
                'property'  => 'name',
                'attr'      => array(
                    'placeholder' => 'back.product.name',
                ),
                'query_builder' => function(EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC')
                    ;
                },
            ))
            ->add('recipe', 'hidden', array(
                'mapped'    => false,
                'label'     => false,
            ))
            ->add('submit', 'submit')
            ->getForm();
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'            => 'Barra\FrontBundle\Entity\Ingredient',
            'intention'             => 'ingredient',
            'csrf_protection'       => false,
            'cascade_validation'    => true,
            'validation_groups'     => array(
                'ingredient',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'formIngredient';
    }
}