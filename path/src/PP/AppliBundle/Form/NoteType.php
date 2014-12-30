<?php

namespace PP\AppliBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note', 'choice', array(
                'label'         => 'Noter la recette :',
                'choices'       => array(0 => '0', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'),
                'required'      => false,
                'expanded'      => false,
                'multiple'      => false,
                'empty_value'   => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PP\AppliBundle\Entity\Note'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pp_applibundle_note';
    }
}
