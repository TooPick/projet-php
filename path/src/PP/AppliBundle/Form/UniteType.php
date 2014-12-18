<?php

namespace PP\AppliBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UniteType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uniLabel', NULL, array('label' => "Nom :", 'attr' => array('class' => 'form-control')))
            ->add('uniShortLabel', NULL, array('label' => "Acronyme :", 'attr' => array('class' => 'form-control')))
            ->add('uniDescription', NULL, array('label' => "Desription :", 'attr' => array('class' => 'form-control')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PP\AppliBundle\Entity\Unite'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pp_applibundle_unite';
    }
}
