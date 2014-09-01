<?php

namespace Barra\BackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UploadedImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipe', 'hidden', array('mapped' => false, 'label'=>false))
            ->add('file', 'file')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class'=>'Barra\FrontBundle\Entity\UploadedImage',
            'intention' =>'recipeFile'
        ));
    }

    public function getName()
    {
        return 'formUploadedImage';
    }
}