<?php

namespace Barra\BackBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ProductType
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Form\Type
 */
class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'attr'      => array(
                        'placeholder' => 'back.product.name',
                    ),
                ))
            ->add('vegan', 'checkbox', array(
                    'required' => false,
                ))
            ->add('gr', 'integer', array(
                    'attr'      => array(
                        'placeholder' => 'back.product.gr',
                    )
                ))
            ->add('kcal', 'number', array(
                    'precision' => 2,
                    'attr'      => array(
                        'placeholder' => 'back.product.kcal',
                    )
                ))
            ->add('protein', 'number', array(
                    'precision' => 2,
                    'attr'      => array(
                        'placeholder' => 'back.product.protein',
                    )
                ))
            ->add('carbs', 'number', array(
                    'precision' => 2,
                    'attr'      => array(
                        'placeholder' => 'back.product.carbs',
                    )
                ))
            ->add('sugar', 'number', array(
                    'precision' => 2,
                    'attr'      => array(
                        'placeholder' => 'back.product.sugar',
                    )
                ))
            ->add('fat', 'number', array(
                    'precision' => 2,
                    'attr'      => array(
                        'placeholder' => 'back.product.fat',
                    )
                ))
            ->add('gfat', 'number', array(
                    'precision' => 2,
                    'attr'      => array(
                        'placeholder' => 'back.product.gfat',
                    )
                ))
            ->add('manufacturer', 'entity', array(
                    'class'     => 'BarraFrontBundle:Manufacturer',
                    'property'  => 'name',
                    'attr'      => array(
                        'placeholder' => 'back.manufacturer.name',
                    ),
                    'query_builder' => function(EntityRepository $er) {
                        return $er
                            ->createQueryBuilder('m')
                            ->orderBy('m.name', 'ASC')
                        ;
                    },
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
            'data_class'        => 'Barra\FrontBundle\Entity\Product',
            'intention'         => 'product',
            'csrf_protection'   => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'formProduct';
    }
}