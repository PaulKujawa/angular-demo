<?php

namespace Barra\BackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('website', 'text', array('attr'=>array('placeholder'=>'back.reference.website')))
            ->add('company', 'text', array('attr'=>array('placeholder'=>'back.reference.company')))
            ->add('description', 'textarea', array('attr'=>array('placeholder'=>'back.reference.description')))
            ->add('started', 'date', array('widget'=>'single_text', 'format'=>'dd.MM.yyyy', 'attr'=>array('placeholder'=>'back.reference.startedPlaceholder')))
            ->add('finished', 'date', array('widget'=>'single_text', 'format'=>'dd.MM.yyyy',  'attr'=>array('placeholder'=>'back.reference.finishedPlaceholder')))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class'=>'Barra\FrontBundle\Entity\Reference',
            'intention' =>'reference'
        ));
    }

    public function getName()
    {
        return 'name';
    }
}