<?php

namespace Barra\BackBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', 'text', array(
                    'attr'=>array('placeholder'=>'back.reference.url')
                ))
            ->add('description', 'textarea', array(
                    'attr'=>array('placeholder'=>'back.reference.description')
                ))
            ->add('started', 'date', array(
                    'widget'=>'single_text',
                    'format'=>'dd.MM.yyyy',
                    'attr'=>array('placeholder'=>'back.reference.startedPlaceholder')
                ))
            ->add('finished', 'date', array(
                    'widget'=>'single_text',
                    'format'=>'dd.MM.yyyy',
                    'attr'=>array('placeholder'=>'back.reference.finishedPlaceholder')
                ))
            ->add('agency', 'entity', array(
                    'class' => 'BarraFrontBundle:Agency',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')->orderBy('a.name', 'ASC');
                    },
                    'property' => 'name'
                ))
            ->add('techniques', 'entity', array(
                    'class' => 'BarraFrontBundle:Technique',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('t')->orderBy('t.name', 'ASC');
                    },
                    'property' => 'name',
                    'multiple' => 'true'
                ))

            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Barra\FrontBundle\Entity\Reference',
            'intention' =>'reference'
        ));
    }

    public function getName()
    {
        return 'formReference';
    }
}