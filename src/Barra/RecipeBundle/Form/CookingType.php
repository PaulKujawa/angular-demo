<?php

namespace Barra\RecipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CookingType
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Form
 */
class CookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'text', [
                'attr' => [
                    'placeholder' => 'recipe.cooking.description',
                ],
            ])
            ->add('recipe', 'hidden', [
                'mapped' => false,
                'label'  => false,
            ])
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'Barra\RecipeBundle\Entity\Cooking',
            'intention'         => 'cooking',
            'csrf_protection'   => false,
        ]);
    }

    public function getName()
    {
        return 'formCooking';
    }
}
