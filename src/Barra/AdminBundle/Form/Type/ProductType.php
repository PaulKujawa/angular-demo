<?php

namespace Barra\AdminBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ProductType
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Form\Type
 */
class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'attr'      => [
                    'placeholder' => 'admin.product.name',
                ],
            ])
            ->add('vegan', 'checkbox', [
                'required' => false,
            ])
            ->add('gr', 'integer', [
                'attr'      => [
                    'placeholder' => 'admin.product.gr',
                ],
            ])
            ->add('kcal', 'integer', [
                'attr'      => [
                    'placeholder' => 'admin.product.kcal',
                ],
            ])
            ->add('protein', 'number', [
                'precision' => 2,
                'attr'      => [
                    'placeholder' => 'admin.product.protein',
                ],
            ])
            ->add('carbs', 'number', [
                'precision' => 2,
                'attr'      => [
                    'placeholder' => 'admin.product.carbs',
                ],
            ])
            ->add('sugar', 'number', [
                'precision' => 2,
                'attr'      => [
                    'placeholder' => 'admin.product.sugar',
                ],
            ])
            ->add('fat', 'number', [
                'precision' => 2,
                'attr'      => [
                    'placeholder' => 'admin.product.fat',
                ],
            ])
            ->add('gfat', 'number', [
                'precision' => 2,
                'attr'      => [
                    'placeholder' => 'admin.product.gfat',
                ],
            ])
            ->add('manufacturer', 'entity', [
                'class'     => 'BarraAdminBundle:Manufacturer',
                'property'  => 'name',
                'attr'      => [
                    'placeholder' => 'admin.manufacturer.name',
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('m')
                        ->orderBy('m.name', 'ASC')
                    ;
                },
            ])
            ->add('submit', 'submit')
            ->getForm()
        ;
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'Barra\AdminBundle\Entity\Product',
            'intention'         => 'product',
            'csrf_protection'   => false,
        ]);
    }


    public function getName()
    {
        return 'formProduct';
    }
}
