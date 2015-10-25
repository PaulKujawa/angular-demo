<?php

namespace Barra\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TechniqueType
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Form\Type
 */
class TechniqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'attr' => [
                    'placeholder' => 'back.technique.name',
                ],
            ])
            ->add('description', 'textarea', [
                'attr' => [
                    'placeholder' => 'back.technique.description',
                ],
            ])
            ->add('url', 'text', [
                'attr' => [
                    'placeholder' => 'back.technique.url',
                ],
            ])
            ->add('submit', 'submit')
            ->getForm()
        ;
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        =>'Barra\AdminBundle\Entity\Technique',
            'intention'         =>'technique',
            'csrf_protection'   => false,
        ]);
    }


    public function getName()
    {
        return 'formTechnique';
    }
}
