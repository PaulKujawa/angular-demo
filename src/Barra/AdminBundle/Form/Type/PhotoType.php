<?php

namespace Barra\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class PhotoType
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Form\Type
 */
class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipe', 'hidden', [
                'mapped' => false,
                'label'  => false,
            ])
            ->add('file', 'file')
            ->getForm()
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'Barra\AdminBundle\Entity\Photo',
            'intention'         => 'recipeFile',
            'csrf_protection'   => false,
        ]);
    }

    public function getName()
    {
        return 'formPhoto';
    }
}
