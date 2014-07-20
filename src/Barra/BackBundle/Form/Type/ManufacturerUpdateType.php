<?php

namespace Barra\BackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ManufacturerUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden', array('mapped' => false, 'label'=>false)) // instead of make setId() possible
            ->add('name', 'text', array('attr'=>array('placeholder'=>'back.manufacturer.name')))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class'=>'Barra\FrontBundle\Entity\Manufacturer',
            'intention' =>'manufacturer'
        ));
    }

    public function getName()
    {
        return 'formManufacturerUpdate';
    }
}