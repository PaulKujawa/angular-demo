<?php

namespace AppBundle\Form;

use AppBundle\Entity\Product;
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
            ->add('name', TextType::class)
            ->add('vegan', CheckboxType::class, [
                'required' => false,
            ])
            ->add('gr', IntegerType::class)
            ->add('kcal', IntegerType::class)
            ->add('protein', NumberType::class, [
                'scale' => 2,
            ])
            ->add('carbs', NumberType::class, [
                'scale' => 2,
            ])
            ->add('sugar', NumberType::class, [
                'scale' => 2,
            ])
            ->add('fat', NumberType::class, [
                'scale' => 2,
            ])
            ->add('gfat', NumberType::class, [
                'scale' => 2,
            ])
            ->add('manufacturer', TextType::class, [
                'required' => false,
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
