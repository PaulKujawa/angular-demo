<?php

namespace Barra\BackBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TechniqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'attr'=>array('placeholder'=>'back.technique.name')
                ))
            ->add('description', 'textarea', array(
                    'attr'=>array('placeholder'=>'back.technique.description')
                ))
            ->add('url', 'text', array(
                    'attr'=>array('placeholder'=>'back.technique.name')
                ))
            ->add('references', 'entity', array(
                    'class' => 'BarraFrontBundle:Reference',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('r')->orderBy('r.url', 'ASC');
                    },
                    'property' => 'name'
                ))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class'=>'Barra\FrontBundle\Entity\Technique',
            'intention' =>'technique'
        ));
    }

    public function getName()
    {
        return 'formTechnique';
    }
}