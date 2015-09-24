<?php

namespace Barra\BackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ScreenshotType
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Form\Type
 */
class ScreenshotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', 'hidden', [
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
            'data_class'        => 'Barra\BackBundle\Entity\Screenshot',
            'intention'         => 'recipeFile',
            'csrf_protection'   => false,
        ]);
    }

    public function getName()
    {
        return 'formScreenshot';
    }
}
