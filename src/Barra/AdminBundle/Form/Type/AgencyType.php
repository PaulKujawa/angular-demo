<?php

namespace Barra\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AgencyType
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Form\Type
 */
class AgencyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'attr' => [
                    'placeholder' => 'back.agency.name',
                ],
            ])
            ->add('url', 'text', [
                'attr' => [
                    'placeholder' => 'back.agency.url',
                ],
            ])
            ->add('submit', 'submit')
            ->getForm()
        ;
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'Barra\AdminBundle\Entity\Agency',
            'intention'         => 'agency',
            'csrf_protection'   => false,

        ]);
    }


    public function getName()
    {
        return 'formAgency';
    }
}
