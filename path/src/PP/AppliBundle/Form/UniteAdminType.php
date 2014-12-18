<?php

namespace PP\AppliBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UniteAdminType extends AbstractType
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
            ->add('uniValide', 'choice', array(
                    'choices'   => array(1 => 'Validé', 0 => 'En Attente'),
                    'required'  => true,
                    'label'     => 'Statut :'
                ))
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
