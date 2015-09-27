<?php

namespace Barra\AdminBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ReferenceType
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Form\Type
 */
class ReferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', 'text', [
                'attr'          => [
                    'placeholder' => 'back.reference.url',
                ],
            ])
            ->add('description', 'textarea', [
                'attr'          => [
                    'placeholder' => 'back.reference.description',
                ],
            ])
            ->add('started', 'date', [
                'widget'        => 'single_text',
                'format'        => 'dd.MM.yyyy',
                'attr'          => [
                    'placeholder' => 'back.reference.startedPlaceholder',
                ],
            ])
            ->add('finished', 'date', [
                'widget'        => 'single_text',
                'format'        => 'dd.MM.yyyy',
                'attr'          => [
                    'placeholder' => 'back.reference.finishedPlaceholder',
                ],
            ])
            ->add('agency', 'entity', [
                'class'         => 'BarraAdminBundle:Agency',
                'property'      => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC')
                    ;
                },
            ])
            ->add('techniques', 'entity', [
                'class'         => 'BarraAdminBundle:Technique',
                'property'      => 'name',
                'multiple'      => 'true',
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC')
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
            'data_class'        => 'Barra\AdminBundle\Entity\Reference',
            'intention'         => 'reference',
            'csrf_protection'   => false,
        ]);
    }


    public function getName()
    {
        return 'formReference';
    }
}
