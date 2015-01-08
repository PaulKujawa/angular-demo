<?php

namespace Barra\BackBundle\Form\Type\Update;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AgencyUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden', array(
                    'mapped' => false,
                    'label'=>false
                ))
            ->add('name', 'text', array(
                    'attr'=>array('placeholder'=>'back.agency.name')
                ))
            ->add('url', 'text', array(
                    'attr'=>array('placeholder'=>'back.agency.url')
                ))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class'=>'Barra\FrontBundle\Entity\Agency',
            'intention' =>'agency'
        ));
    }

    public function getName()
    {
        return 'formAgencyUpdate';
    }
}