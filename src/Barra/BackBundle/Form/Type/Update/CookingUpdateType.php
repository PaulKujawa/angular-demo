<?php

namespace Barra\BackBundle\Form\Type\Update;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CookingUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipe', 'hidden', array(
                    'mapped' => false,
                    'label'=>false
                ))
            ->add('position', 'hidden', array(
                    'label'=>false
                ))
            ->add('description', 'text', array(
                    'attr'=>array('placeholder'=>'back.cooking.description')
                ))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Barra\FrontBundle\Entity\Cooking',
            'intention' =>'cooking'
        ));
    }

    public function getName()
    {
        return 'formCookingUpdate';
    }
}